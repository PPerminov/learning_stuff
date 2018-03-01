const c1 = () => {
  console.log('this is one')
  return c2();
}

const c2 = () => {
  console.log('this is two')
  c3();
}

const c3 = () => {
  console.log('this is three:')
  console.log(Object.getOwnPropertyNames(arguments.callee.caller))
}



c1();
