var __slice = Array.prototype.slice;

define(function(require, exports, module) {
  var Logger;
  Logger = {
    state: false,
    trace: false,
    log: function() {
      var args;
      args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
      if (this.trace === true) console.trace();
      if (this.state === true) console.log("Logged@logger ;)", args);
    }
  };
  return exports.Logger = Logger;
});
