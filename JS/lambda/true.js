var True = function(x) {
    return function(y) {
      return x;
};    };



console.log(True(1)(2))
