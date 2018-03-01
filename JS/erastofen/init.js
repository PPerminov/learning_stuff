const out = x => console.log(x);

const primes = (toNums, knownPrimes = [2, 3], current = 4) => {
  console.log(current)
  if (toNums === current) {
    return knownPrimes;
  }
  for (var knownPrime in knownPrimes) {
    if (current % knownPrimes[knownPrime] === 0) {
      return primes(toNums, knownPrimes, ++current)
    }
  }
  knownPrimes.push(current);
  return primes(toNums, knownPrimes, ++current)
}
