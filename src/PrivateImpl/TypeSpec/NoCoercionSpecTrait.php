<?hh // strict
/*
 * Copyright (c) 2017, Facebook Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

namespace Facebook\TypeAssert\PrivateImpl\TypeSpec;

use type Facebook\TypeAssert\{
  IncorrectTypeException,
  TypeCoercionException
};

trait NoCoercionSpecTrait<T> {
  require implements TypeSpec<T>;

  final public function coerceType(mixed $value): T {
    try {
      return $this->assertType($value);
    } catch (IncorrectTypeException $e) {
      throw TypeCoercionException::withValue($e->getExpectedType(), $value);
    }
  }
}
