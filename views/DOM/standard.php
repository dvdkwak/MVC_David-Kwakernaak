<!-- Background -->
<div class="UC_background">
  <div id="moveCenter" class="UC_title_container">
    <div class="UC_title">
      <h1 id="left">Welcome</h1>
      <h1 id="center">at</h1>
      <h1 id="right">UCode!</h1>
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
      <h1>Get started!</h1>
    </div>
    <div class="UC_content">


      <!-- First section creating your first route -->
      <section id="section1" class="light">
        <h1>Creating your first route</h1>
        <div class="row">
          <div class="col-lg UC_section_push">
            <div class="UC_text">
              <ol>
                <li>
                  <p>
                    Go to the app folder and open the index.php
                  </p>
                </li>
                <li>
                  <p>
                    Go to the line where the comment says:<br>"Start adding your routes here! :D"
                  </p>
                </li>
                <li>
                  <p>
                    Create a new route by using $route->add();
                  </p>
                </li>
                <li>
                  <p>
                    Each route will require a path (in example: "about")
                  </p>
                </li>
                <li>
                  <p>
                    Optional are:
                    <ul>
                      <li>
                        <p>
                            page title
                        </p>
                      </li>
                      <li>
                        <p>
                            view
                        </p>
                      </li>
                      <li>
                        <p>
                            controller
                        </p>
                      </li>
                      <li>
                        <p>
                            Stylesheets (as array)
                        </p>
                      </li>
                      <li>
                        <p>
                            script sheet (as array)
                        </p>
                      </li>
                      <li>
                        <p>
                            additional data
                        </p>
                      </li>
                    </ul>
                  </p>
                </li>
              </ol>
            </div>
          </div>
          <div class="col-lg">
            <div class="UC_code right">
              <p>
                <span style="color:#757575">// This iniates the standard (home) page ($url = "/home")</span><br>
                <span style="color:rgb(255,99,71);">$route</span>-><span style="color:rgb(89,152,255)">add</span>();
                <span style="color:#757575"> // to catch the "home" url</span><br>
                <br>
                <span style="color:#757575">// Start adding your routes here! :D</span><br>
                <br>
                <span style="color:#757575">// real path example</span><br>
                <span style="color:rgb(255,99,71);">$route</span>-><span style="color:rgb(89,152,255)">add</span>(<span style="color:#f4e755">"about"</span>, <span style="color:#f4e755">"about me :D"</span>, <span style="color:#f4e755">"about.php"</span>, <span style="color:#f4e755">""</span>, [<span style="color:#f4e755">"about.css"</span>]);<br>
                <br>
                <span style="color:#757575">// variable path example {id} can be called by using $page['id']</span><br>
                <span style="color:rgb(255,99,71)">$route</span>-><span style="color:rgb(89,152,255)">add</span>(<span style="color:#f4e755">"article/{id}"</span>, <span style="color:#f4e755">"articles"</span>, <span style="color:#f4e755">"article.php"</span>, <span style="color:#f4e755">""</span>, [<span style="color:#f4e755">"article.css"</span>]);<br>
              </p>
            </div>
          </div>
        </div>
      </section>


      <!-- 2nd section, Creating your first view -->
      <section class="right">
        <h1>Creating your first view</h1>
        <div class="row">
          <div class="col-lg UC_section_push">
            <div class="UC_code">
              <p>
                <span style="color:#757575">&#60;!-- This is an example page using the "article/{id}" route --></span><br>
                <br>
                <<span style="color:rgb(255,99,71)">h1</span>>I am the awesome article page!<<span style="color:rgb(255,99,71)">h1</span>><br>
                <br>
                <br>
                <span style="color:#757575">&#60;!-- Calling $page['id'] well use the given {id} --></span><br>
                <br>
                <span style="color:red">&#60;?php</span> <span style="color:skyblue">echo</span> <span style="color:rgb(255,99,71)">$page</span>[<span style="color:#f4e755">'id'</span>]; <span style="color:red">?></span>
              </p>
            </div>
          </div>
          <div class="col-lg">
            <div class="UC_text right">
              <ol>
                <li>
                  <p>
                    Go to the views folder and create a new file called article.php in the DOM folder
                  </p>
                </li>
                <li>
                  <p>
                    In this file you do <b>not</b> include things like bootstrap<br>(these are done in the app/index.php)
                  </p>
                </li>
                <li>
                  <p>
                    You should <b>not</b> use html, head or body tags as these are created for you in app/index.php
                  </p>
                </li>
                <li>
                  <p>
                    Start creating your awesome html/php page :)
                  </p>
                </li>
                <li>
                  <p>
                    if you want to use the variable id your file must be a php file (see the example)
                  </p>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </section>


      <!-- 3th section, Styling your view -->
      <section class="light">
        <h1>Styling your view</h1>
        <div class="row">
          <div class="col-lg UC_section_push">
            <div class="UC_text">
              <p><b>The <i>CSS</i> way:</b></p>
              <ol>
                <li>
                  <p>
                    Go to app/css and create here your CSS file
                  </p>
                </li>
                <li>
                  <p>
                    I should not be explaining CSS here...
                  </p>
                </li>
                <li>
                  <p>
                    Make sure to include this stylesheet in your route!
                  </p>
                </li>
              </ol><br>
              <p><b>The <i>SASS</i> way:</b></p>
              <ol>
                <li>
                  <p>
                    Go to views.sass and create here your SASS file
                  </p>
                </li>
                <li>
                  <p>
                    If you have installed node and gulp:
                  </p>
                  <ol>
                    <li>
                      <p>
                        go to project folder in CMD
                      </p>
                    </li>
                    <li>
                      <p>
                        start gulp by typing "gulp"
                      </p>
                    </li>
                    <li>
                      <p>
                        Make sure not to forget to first install all needed modules!
                      </p>
                    </li>
                  </ol>
                </li>
                <li>
                  no gulp? Then make sure you get a sass compiler, and put the generated files in the app/css folder
                </li>
              </ol>
            </div>
          </div>
          <div class="col-lg">
            <div class="UC_code right">
              <p>
                <span style="color:#757575">// Tiny sass example for the "article/{id}" route, save this as article.scss</span><br>
                <br>
                <span style="color:rgb(255,99,71)">body</span>{<br>
                &nbsp;&nbsp;background: <span style="color:#f4e755">CornflowerBlue</span>;<br>
                &nbsp;&nbsp;color: <span style="color:#f4e755">white</span>;<br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:rgb(255,99,71)">h1</span>{<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;font-size: <span style="color:#f4e755">64px</span>;<br>
                &nbsp;&nbsp;}<br>
                }
              </p>
            </div>
          </div>
        </div>
      </section>


    </div>
  </div>
</div>
