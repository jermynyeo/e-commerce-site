const easingBezier = (mX1, mY1, mX2, mY2) => {
  'use strict';

  const a = (aA1, aA2) => {
    return 1.0 - 3.0 * aA2 + 3.0 * aA1;
  };

  const b = (aA1, aA2) => {
    return 3.0 * aA2 - 6.0 * aA1;
  };

  const c = (aA1) => {
    return 3.0 * aA1;
  };

  // Returns x(t) given t, x1, and x2, or y(t) given t, y1, and y2.
  const calcBezier = (aT, aA1, aA2) => {
    return ((a(aA1, aA2) * aT + b(aA1, aA2)) * aT + c(aA1)) * aT;
  };

  // Returns dx/dt given t, x1, and x2, or dy/dt given t, y1, and y2.
  const getSlope = (aT, aA1, aA2) => {
    return 3.0 * a(aA1, aA2) * aT * aT + 2.0 * b(aA1, aA2) * aT + c(aA1);
  };

  const getTForX = (aX) => {
    // Newton raphson iteration
    let aGuessT = aX;
    for (let i = 0; i < 4; ++i) {
      let currentSlope = getSlope(aGuessT, mX1, mX2);
      if (currentSlope === 0.0) {
        return aGuessT;
      }
      let currentX = calcBezier(aGuessT, mX1, mX2) - aX;
      aGuessT -= currentX / currentSlope;
    }
    return aGuessT;
  };

  if (mX1 === mY1 && mX2 === mY2) {
    return {
      css: 'linear',
      fn(aX) {
        return aX;
      }
    };
  }

  return {
    css: `cubic-bezier(${mX1},${mY1},${mX2},${mY2})`,
    fn(aX) {
      return calcBezier(getTForX(aX), mY1, mY2);
    }
  };
};

export default easingBezier;
