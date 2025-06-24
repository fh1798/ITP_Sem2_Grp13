<?php
require_once("config/dbaccess.php");

// nur eingeloggte User können Chatroom verwenden
if (!isset($_SESSION["benutzerID"])) {
    echo '<div class="container mt-5"><div class="alert alert-warning text-center">⚠️ Bitte loggen Sie sich ein, um den Chatraum zu betreten.</div></div>';
    exit();
}

// nachricht speichern
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["content"]) && isset($_SESSION["benutzerID"])) {
    $benutzer_id = $_SESSION["benutzerID"];
    $content = $db_obj->real_escape_string($_POST["content"]);
    $numberPrefix = isset($_POST["numberPrefix"]) && $_POST["numberPrefix"] !== '' ? intval($_POST["numberPrefix"]) : null;

    $stmt = $db_obj->prepare("INSERT INTO chatnachrichten (benutzer_id, content, artikelFK) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $benutzer_id, $content, $numberPrefix);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') !== false ? '&' : '?') . 'scrollToBottom=1');
    exit();
}
?>

<div class="position-relative w-100 min-vh-100 chatroom-bg-image d-flex flex-column align-items-center justify-content-start p-3">
    <!-- Blur Layer -->
    <div class="position-absolute top-0 start-0 w-100 h-100 backdrop-blur"></div>

    <!-- Chat Content -->
    <div class="position-relative z-1 container-fluid pb-1">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 text-center text-md-start">
        <h2 class="text-white mb-3 mb-md-0"><b>CHATROOM</b></h2>
        <div class="d-flex gap-2 justify-content-center justify-content-md-start">
            <div class="bg-selector bg-color-1" data-bg="bg1"></div>
            <div class="bg-selector bg-color-2" data-bg="bg2"></div>
            <div class="bg-selector bg-color-3" data-bg="bg3"></div>
            <div class="bg-selector bg-color-4" data-bg="bg4"></div>
            <div class="bg-selector bg-color-5" data-bg="bg5"></div>
        </div>
    </div>

        <div class="border rounded p-3 mb-4 d-flex flex-column bg-light bg-opacity-25" style="height: 400px;" id="chat-box">
            <div class="flex-grow-1 pe-2" id="message-area" style="overflow-y: auto; max-height: 520px; scroll-behavior: smooth;">
                <?php
                $sql = "SELECT cm.content, cm.time, b.vorname, cm.artikelFK, a.artikelBildSrc 
                        FROM chatnachrichten cm 
                        JOIN benutzer b ON cm.benutzer_id = b.benutzerID 
                        LEFT JOIN artikel a ON cm.artikelFK = a.artikelID 
                        ORDER BY cm.time ASC";
                $result = $db_obj->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $timestamp = date("H:i", strtotime($row["time"]));
                        $isOwn = $row["vorname"] === $_SESSION["vorname"];
                        $alignment = $isOwn ? "justify-content-end" : "justify-content-start";
                        $strongColor = $isOwn ? "bg-primary text-white" : "bg-warning text-white";
                        $lightColor = $isOwn ? "bg-primary bg-opacity-25" : "bg-warning bg-opacity-25";

                        echo "<div class='d-flex mb-3 {$alignment}'>
                                <div class='chat-bubble p-2 rounded {$lightColor}'>
                                    <div class='name-bubble px-2 py-1 mb-1 rounded-pill {$strongColor} d-inline-block'>
                                        <strong>" . htmlspecialchars($row["vorname"]) . "</strong> <small>($timestamp)</small>
                                    </div>
                                    <div class='message-text'>
                                        " . htmlspecialchars($row["content"]) . "
                                    </div>";

                        if (!empty($row["artikelBildSrc"]) && !empty($row["artikelFK"])) {
                            $artikelID = htmlspecialchars($row["artikelFK"]);
                            $bildSrc = htmlspecialchars($row["artikelBildSrc"]);
                            echo "<div class='mt-2'>
                                    <a href='index.php?page=artikeldetailansicht&artikelID={$artikelID}' target='_blank' title='Zur Detailansicht'>
                                        <img src='{$bildSrc}' alt='Produktbild' style='max-width: 150px; max-height: 150px;' class='img-fluid rounded'>
                                    </a>
                                </div>";
                        }

                        echo "  </div>
                            </div>";
                    }
                } else {
                    echo "<p class='text-muted text-center'>Noch keine Nachrichten vorhanden.</p>";
                }
                ?>
            </div>

            <form id="chat-form" method="POST" class="mt-auto pt-2 border-top">
                <div class="row g-2">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text">ID #</span>
                            <input type="number" name="numberPrefix" class="form-control" min="0" placeholder="">
                            <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="top" title="Die ID finden Sie oben in den Produktdetails eines Artikels.">
                                <i class="bi bi-info-circle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="content" class="form-control" placeholder="Nachricht eingeben..." required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn w-100 border border-1 bg-white">Senden</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById("chat-form");
    const messageArea = document.getElementById("message-area");

    // Scroll to bottom function
    function scrollToBottom() {
        if (messageArea) {
            messageArea.scrollTop = messageArea.scrollHeight;
        }
    }

    // Handle scroll on page load
    const urlParams = new URLSearchParams(window.location.search);
    const shouldScroll = urlParams.get('scrollToBottom') === '1' || true;

    if (shouldScroll) {
        setTimeout(scrollToBottom, 50);
        setTimeout(scrollToBottom, 200);
        setTimeout(scrollToBottom, 500);
        setTimeout(scrollToBottom, 1000);

        if (urlParams.get('scrollToBottom')) {
            urlParams.delete('scrollToBottom');
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState({}, '', newUrl);
        }
    }

    // AJAX message send
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("", {
            method: "POST",
            body: formData
        })
        .then(() => {
            form.reset();
            location.reload(); // Refresh to show new message
        })
        .catch(error => {
            console.error('Error:', error);
            location.reload(); // Fallback in case of error
        });
    });

    // Background selection and persistence
    document.querySelectorAll('.bg-selector').forEach(circle => {
        circle.addEventListener('click', () => {
            const bgClass = circle.getAttribute('data-bg');
            const chatroom = document.querySelector('.chatroom-bg-image');

            // Remove old background classes
            chatroom.classList.remove('bg1', 'bg2', 'bg3', 'bg4', 'bg5');

            // Add new background class
            chatroom.classList.add(bgClass);

            // Save selected background to localStorage
            localStorage.setItem('chatBackground', bgClass);
        });
    });

    // Restore background on page load
    document.addEventListener('DOMContentLoaded', () => {
        const savedBg = localStorage.getItem('chatBackground');
        if (savedBg) {
            const chatroom = document.querySelector('.chatroom-bg-image');
            chatroom.classList.add(savedBg);
        }
    });
</script>
