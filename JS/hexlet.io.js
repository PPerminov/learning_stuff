function eq(x, y) {
  if (x === y) {
    return true
  } else {
    return false
  }
}

function out(data) {
  console.log(data) // Вывод в консоль
}




function math666() {
  out(3 * 7)
  out(4.2 / 3.4)
  out(2 + 2 * 2)
  out((2 + 2) * 2)
  out(3 + 4 - 3 + 1)
  out((7 / 3) * ((100 % 7) - 2))
}
// math666()

function numbers() {
  out(0.3 - 0.2);
  out("Aasfr" * 415231564123145641263);
  out(-1 / 0);
  out(3 % 0);
  out(-Infinity + Infinity);
  out(eq(Infinity, -Infinity));
  out(-1 / (1 / Infinity))
}
// numbers()

function structure() {;;;;
  3;
  4 + 5;
  8
}
// out(structure())

function consts() {
  const pi = 3.14159265359
  const circumference = 2 * 3 * pi
  out(circumference)
  const R = 5
  const area = pi * 4 * R * R
  out(area)
}
// consts()




// lesson Functions


// const <name> = (<argument>) => {
// return <expressions>;
// };
const fu1 = (value1) => {
  return value1
}
const fu2 = (value1) => value1

// out(fu2(666))
// out(fu1(666))
const squareOfSum = (a, b) => {
  return a * a + 2 * a * b + b * b
}

// out(squareOfSum(2,3))


//expressions - almost all is it
const square = (x) => x * x
const sumOfSquares = (x, y) => square(x) + square(y)
const squareSumOfSquares = (x, y) => sumOfSquares(x, y) * sumOfSquares(x, y)






//modules
/*
import * as name from './name';
name.someFunction()

import { someFunction, anotherFunction } from './name';
someFunction()

import { request as r, get } from 'http';
r();

Exports:

//Constant
const favColor = grey
export default favColour
export const facebook = USA

//Anonimous function
export default () => 'Hello, world!';

При импорте необходимо указывать файл относительно FS без расширения js
import * as somename from '../../somename' импортирует экспортированное в виде somename.имя
import somename from '../../somename' импортирует экспортированное по умолчанию
import { getTriangleArea } from './myMathModule' импортирует одну конкретную функцию

*/
