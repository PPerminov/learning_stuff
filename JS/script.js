"use strict";

function isEmpty(obj) {
  var count = 0;
  for (var key in obj) {
    count++;
  }
  if (count == 0) {
    return true;
  } else {

    return false;
  }
}

function sumSalary(obj) {
  var count = 0;
  for (var key in obj) {
    count += obj[key];
  }
  if (count == 0) {
    return 0;
  } else {

    return count;
  }
}

function maxSalary(obj) {

  var currmax = 0;
  var currname = "";
  for (var key in obj) {
    if (obj[key] > currmax) {
      currmax = obj[key];
      currname = key;
    }
  }
  if (currmax == 0) {
    return 0;
  } else {

    return currname;
  }
}

function get_million() {
  var result = "1";
  var count = 0;
  while (count < 100000000) {
    result = result + "0";
    count++;
  }
}


get_million();
