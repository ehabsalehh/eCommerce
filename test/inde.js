function loop(x) {
  if (x >= 10) // "x >= 10" is the exit condition (equivalent to "!(x < 10)")
    return;
  // do stuff
  console.log('begin: ' + x);
  loop(x + 1); // the recursive call
  console.log('beend: ' + x);
  console.log('beenddddd: ' + x);


}
loop(0);