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

use namespace HH\Lib\Vec;

final class VecLikeArraySpec<T> implements TypeSpec<array<T>> {
  public function __construct(
    private TypeSpec<T> $inner,
  ) {
  }

  public function coerceType(mixed $value): array<T> {
    if (!$value instanceof Traversable) {
      throw TypeCoercionException::withValue('array<T>', $value);
    }

    return Vec\map(
      $value,
      $inner ==> $this->inner->coerceType($inner),
    ) |> array_values($$);
  }

  public function assertType(mixed $value): array<T> {
    if (!is_array($value)) {
      throw IncorrectTypeException::withValue('array<T>', $value);
    }

    return Vec\map(
      $value,
      $inner ==> $this->inner->assertType($inner),
    ) |> array_values($$);
  }
}
