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

    $stmt = $db_obj->prepare("INSERT INTO chatnachrichten (benutzer_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $benutzer_id, $content);
    $stmt->execute();
    $stmt->close();

    exit();
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Chatroom</h2>

    <!-- chatroom container -->
    <div class="border rounded p-3 mb-4" style="height: 400px; overflow-y: auto;" id="chat-box">
        <?php
        $sql = "SELECT cm.content, cm.time, b.vorname FROM chatnachrichten cm 
                JOIN benutzer b ON cm.benutzer_id = b.benutzerID 
                ORDER BY cm.time ASC";
        $result = $db_obj->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $timestamp = date("H:i", strtotime($row["time"]));
                $isOwn = $row["vorname"] === $_SESSION["vorname"];
                $alignment = $isOwn ? "text-end" : "text-start";
                $bg = $isOwn ? "bg-primary text-white" : "bg-light";

                echo "<div class='mb-2 {$alignment}'>
                <div class='d-inline-block p-2 rounded {$bg}'>
                    <small><strong>" . htmlspecialchars($row["vorname"]) . "</strong> <em>($timestamp)</em></small><br>
                    " . htmlspecialchars($row["content"]) . "
                </div>
              </div>";
            }
        } else {
            echo "<p class='text-muted text-center'>Noch keine Nachrichten vorhanden.</p>";
        }
        ?>
    </div>

    <!-- Formular -->
    <form id="chat-form" method="POST">
        <div class="row g-2">
            <div class="col-sm-10">
                <input type="text" name="content" class="form-control" placeholder="Nachricht eingeben..." required>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success w-100">Senden</button>
            </div>
        </div>
    </form>
</div>

<script>
    const form = document.getElementById("chat-form");
    const chatBox = document.getElementById("chat-box");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("", {
            method: "POST",
            body: formData
        })
        .then(() => {
            form.reset();
            location.reload(); 
        });
    });

    // scrollt automatisch nach unten
    chatBox.scrollTop = chatBox.scrollHeight;

    // alle 100 Sekunden automatische Aktualisierung
    setInterval(() => {
        location.reload();
    }, 100000);
</script>

