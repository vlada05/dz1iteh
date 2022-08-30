<?php

include "crud.php";
session_start();

if (isset($_POST['type'])) {
  if ($_POST['type'] == 1) {
    CRUD_Operations::getInstance()->register($_POST['regName'], $_POST['regPw'], $_POST['regEmail']);
    exit();
  }

  if ($_POST['type'] == 2) {
    CRUD_Operations::getInstance()->login($_POST['logEmail'], $_POST['logPw']);
    exit();
  }
}

if (isset($_POST['action'])) {

  if ($_POST['action'] == "insert") {
    CRUD_Operations::getInstance()->insert($_POST['activityName'], $_POST['startingTime'], $_POST['endingTime'], $_POST['description']);
    exit();
  }

  if ($_POST['action'] == "fetch_single") {
    CRUD_Operations::getInstance()->selectOne($_POST["id"]);
    exit();
  }

  if ($_POST['action'] == "update") {
    CRUD_Operations::getInstance()->edit($_POST['activityName'], $_POST['startingTime'], $_POST['endingTime'], $_POST['description'], $_POST["hidden_id"]);
    exit();
  }

  if ($_POST['action'] == "delete") {
    CRUD_Operations::getInstance()->delete($_POST["id"]);
    exit();
  }
}
