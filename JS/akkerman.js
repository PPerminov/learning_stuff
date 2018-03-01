function akkermann(m, n) {
  if (m < 0 || n < 0) {
    return
  }
  if (m === 0) {
    return n + 1

  } else if (m > 0 && n === 0) {
    return akkermann(m - 1, 1)
  }

  return akkermann(m - 1, akkermann(m, n - 1))
}
