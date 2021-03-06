<!DOCTYPE html>
<html lang = "en">
<head>
  <div class="menu">
    <?php include '../header.php'; ?>
    <br><br>
  </div>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include "../globalphpfunction.php";
  require '../Credential.php';//load Credential for sql login

  echo isRanked("gLookup");

  $sql = "SELECT * FROM campus";//sql statement

  //If post request was called, (use when search method is called)
  if($_SERVER["REQUEST_METHOD"] == "POST" )
  {
    global $sql;
    $sql = "SELECT * FROM campus WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

  }
  //generate row when recieving result back from the sql execution
  function populateTable(){
    global $sql;
    require '../Credential.php';//load Credential for sql login
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //check if there is get method
    if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
      //if there's set sql to get
      $sql = "SELECT * FROM campus WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
    }

    //execute sql
    $result = $conn->query($sql);
    //for each row return from the sql
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $Name = $row["Name"];
        $Abb = $row["Abb"];
        $Address =$row["Address"];
        $State = $row["State"];
        $Zip = $row["Zip"];
        $Country = $row["Country"];
        // set html format row
        echo "<tr>
        <td>".$id."</td>
        <td>".$Name."</td>
        <td>".$Abb."</td>
        <td>".$Address."</td>
        <td>".$State."</td>
        <td>".$Zip."</td>
        <td>".$Country."</td>
        <td><a href = DeleteCampus.php?id=".$id." onclick=\"return confirm('Are you sure to delete Campus in id: ".$id."');\"> Delete </a> &nbsp</td>
        <td><a href = UpdateCampus.php?id=".replaceSpace($id)."&Name=".replaceSpace($Name)."&Abb=".replaceSpace($Abb)."&Address=".replaceSpace($Address)."&State=".replaceSpace($State)."&Zip=".replaceSpace($Zip)."&Country=".replaceSpace($Country)."> Edit </a> &nbsp</td>
        </tr>";
      }
    }

    $conn->close();
  }
  ?>
</head>
<body>
  <div class="container-fluid">
    <div class = "row">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p id = "search">
          Search
          <!-- <div class="dropdown"> fixed dropmenu for search
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
              <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a href="#">HTML</a></li>
                <li><a href="#">CSS</a></li>
                <li><a href="#">JavaScript</a></li>
              </ul>
            </div> -->
            <select name="key">
              <option value="Name">Name</option>
              <option value="Abb">Abb</option>
              <option value="Address">Address</option>
              <option value="State">State</option>
              <option value="Zip">Zip</option>
              <option value="Country">Country</option>
            </select>
            Keyword: <input type="text" name="keyword" class="input-sm  ">
            <input type="submit" name="submit" value="Submit" class="btn btn-search btn-xs">
          </p>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Result
          </div>
          <div class="panel-body">
            <div class="dataTable_wrapper">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Abb</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Country</th>
                    <th>Delete</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  populateTable();
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
