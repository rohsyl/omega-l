var trads = {{ $trads }};
function __(key){ if(trads.hasOwnProperty(key)) {return trads[key];} return key; }