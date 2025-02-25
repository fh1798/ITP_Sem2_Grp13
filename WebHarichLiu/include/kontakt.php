<!-- ein nicht eingebundenes Kontaktformular, um mit dem Hotel in Kontakt zu treten. -->

<?php include '../include/header.php';?>


<div class="contaner bg-gradient py-2">
  <h1 class="text-center text-dark mt-3">Kontakt</h1>
  <div class="container ">
    <form action="/action_page.php" methode="post" class="border border-secondary rounded p-4 shadow-sm">
      <div class="form-group">
        <div class="row">
          <div class="col-25">
            <label for="fname">Vorname</label>
          </div>
          <div class="col-75">
            <input type="text" id="fname" name="vorname" placeholder="Your name..">
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="lname">Nachname</label>
          </div>
          <div class="col-75">
            <input type="text" id="lname" name="nachname" placeholder="Your last name..">
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="country">Land</label>
          </div>
          <div class="col-75">
            <select id="country" name="country">
              <option value="austria">Österreich</option>
              <option value="germany">Deutschland</option>
              <option value="switzland">Schweiz</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="subject">Subject</label>
          </div>
          <div class="col-75">
            <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
          </div>
        </div>
        <div class="row">
          <input type="submit" value="Submit">
        </div>
      </div>
      
      
    </form>
  </div>
</div> 
