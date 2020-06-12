<?php declare(strict_types = 1);

namespace App\Services;


use http\Exception\InvalidArgumentException;

/**
 * Class CreditScoreTransformer
 *
 * @package App\Services
 */
class CreditScoreTransformer
{
    public const SCORE_GOOD_KEY = 'good';
    public const SCORE_BAD_KEY = 'bad';

    private const AVAILABLE_SCORES = [
        self::SCORE_GOOD_KEY,
        self::SCORE_BAD_KEY
    ];
    private const SCORES_VALUES_MAP = [
        self::SCORE_GOOD_KEY => 700,
        self::SCORE_BAD_KEY => 300
    ];

    /**
     * @param string $scoreKey
     *
     * @return int
     */
    public function transform(string $scoreKey): int
    {
        if (!in_array($scoreKey, self::AVAILABLE_SCORES)) {
            throw new InvalidArgumentException('There is no score with such key!');
        }

        return self::SCORES_VALUES_MAP[$scoreKey];
    }
}
