
$.fn.serializeToArray = function() {
  var datas, i, result, _i, _len;
  result = {};
  datas = this.serializeArray();
  for (_i = 0, _len = datas.length; _i < _len; _i++) {
    i = datas[_i];
    result[i.name] = i.value;
  }
  return result;
};
