<!-- Background -->
<div class="UC_background">
  <div id="moveCenter" class="UC_title_container">
    <div class="UC_title">
      <h1 id="left">Something</h1>
      <h1 id="center">seems</h1>
      <h1 id="right">Wrong! :0</h1>
    </div>
  </div>
</div>

<!-- Menu fixed at top -->
<div class="UC_menu">
  <h1>UCode</h1>
</div>

<!-- pusher to push down the content -->
<div id="pushDown"></div>

<!-- Content div -->
<div class="container-fluid">
  <div class="row">
    <div onclick="scrollDownToTarget('section1')" class="UC_getReady_btn">
      <h1>FIX IT!</h1>
    </div>
    <div class="UC_content">

      <section id="section1" class="light">
        <h1>Oh Boy!</h1>
        <div class="row">
          <div class="col-lg UC_section_push">
            <div class="UC_text">
              <p>
                Aii, you seem to have some nasty <b>errors</b>...<br>
                <br>
                Ah well, <b>no worries</b>! Let's get your errors <b>fixed</b>!<br>
                <br>
                <br>
                In <b>the boxes</b> below will be an explenation of <b>what went wrong</b> according to the system.
                Furthermore, on the other side of the explenation you will find a code box which will try and show you how your current code looks and what it should be.
              </p>
            </div>
          </div>
          <div class="col-lg">
            <div class="UC_code right">
              <p>
                <span style="color:#757575">// Example code box</span><br>
                <br>
                <span style="color:#757575">// The following route has a misstake in it:</span><br>
                <span style="color:rgb(255,99,71);">$route</span>-><span style="color:rgb(89,152,255)">add</span>(<span style="color:#f4e755">"somepath"</span>
                , <u><span style="color:#f4e755">"someView.php"</span></u>, <span style="color:#f4e755">"someTitle"</span>);<br>
              </p>
            </div>
          </div>
        </div>
      </section>

      <?php
        $i = 1;
        foreach($page['errors'] AS $error){ // Create a section for each error found by the system
      ?>
        <section <?php if($i%2 === 0){echo"class=\"light\"";}else{echo"class=\"right\"";} ?>>
          <h1><?php echo $error['name'] ?></h1>
          <div class="row">
            <div class="col-lg UC_section_push">
              <?php
              if($i%2 === 0){
              ?>
              <div class="UC_text">
                <p><?php echo $error['textResponse'] ?></p>
              </div>
              <?php }else{ ?>
              <div class="UC_code">
                <p>
                  <?php echo $error['codeResponse']; ?>
                </p>
              </div>
              <?php } ?>
            </div>
            <div class="col-lg">
              <?php
              if($i%2 !== 0){
              ?>
              <div class="UC_text right">
                <p><?php echo $error['textResponse'] ?></p>
              </div>
              <?php }else{ ?>
              <div class="UC_code right">
                <p>
                  <?php echo $error['codeResponse'] ?>
                </p>
              </div>
              <?php } ?>
            </div>
          </div>
        </section>
      <?php
          $i+=1;
        }
      ?>


    </div>
  </div>
</div>
