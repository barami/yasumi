<?php

declare(strict_types=1);

/*
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2023 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me at sachatelgenhof dot com>
 */

namespace Yasumi\tests\SouthKorea;

use Yasumi\Holiday;
use Yasumi\Provider\SouthKorea;
use Yasumi\tests\HolidayTestCase;

/**
 * Class for testing Buddha's Birthday in South Korea.
 */
class BuddhasBirthdayTest extends SouthKoreaBaseTestCase implements HolidayTestCase
{
    /**
     * The name of the holiday.
     */
    public const HOLIDAY = 'buddhasBirthday';

    /**
     * The year in which the holiday was first established.
     */
    public const ESTABLISHMENT_YEAR = 1975;

    /**
     * Tests the holiday defined in this test.
     *
     * @throws \Exception
     */
    public function testHoliday(): void
    {
        $year = $this->generateRandomYear(self::ESTABLISHMENT_YEAR, 2050);
        if (isset(SouthKorea::LUNAR_HOLIDAY[self::HOLIDAY][$year])) {
            $this->assertHoliday(
                self::REGION,
                self::HOLIDAY,
                $year,
                new \DateTime(SouthKorea::LUNAR_HOLIDAY[self::HOLIDAY][$year], new \DateTimeZone(self::TIMEZONE))
            );
        }
    }

    /**
     * Tests substitute holidays.
     *
     * @dataProvider SubstituteHolidayDataProvider
     *
     * @param int     $year     the year for which the holiday defined in this test needs to be tested
     * @param ?string $expected the expected date
     *
     * @throws \Exception
     */
    public function testSubstituteHoliday(int $year, ?string $expected): void
    {
        if (isset(SouthKorea::LUNAR_HOLIDAY[self::HOLIDAY][$year])) {
            if ($expected) {
                $this->assertSubstituteHoliday(
                    self::REGION,
                    self::HOLIDAY,
                    $year,
                    new \DateTime($expected, new \DateTimeZone(self::TIMEZONE))
                );
            } else {
                $this->assertNotSubstituteHoliday(
                    self::REGION,
                    self::HOLIDAY,
                    $year
                );
            }
        }
    }

    /**
     * Tests the holiday defined in this test before establishment.
     *
     * @throws \Exception
     */
    public function testHolidayBeforeEstablishment(): void
    {
        $this->assertNotHoliday(
            self::REGION,
            self::HOLIDAY,
            $this->generateRandomYear(1000, self::ESTABLISHMENT_YEAR - 1)
        );
    }

    /**
     * Tests the translated name of the holiday defined in this test.
     *
     * @throws \Exception
     */
    public function testTranslation(): void
    {
        $year = $this->generateRandomYear(self::ESTABLISHMENT_YEAR, 2050);
        if (isset(SouthKorea::LUNAR_HOLIDAY[self::HOLIDAY][$year])) {
            $this->assertTranslatedHolidayName(
                self::REGION,
                self::HOLIDAY,
                $year,
                [self::LOCALE => '부처님오신날']
            );
        }
    }

    /**
     * Tests type of the holiday defined in this test.
     *
     * @throws \Exception
     */
    public function testHolidayType(): void
    {
        $year = $this->generateRandomYear(self::ESTABLISHMENT_YEAR, 2050);
        if (isset(SouthKorea::LUNAR_HOLIDAY[self::HOLIDAY][$year])) {
            $this->assertHolidayType(
                self::REGION,
                self::HOLIDAY,
                $year,
                Holiday::TYPE_OFFICIAL
            );
        }
    }

    /**
     * Returns a list of test dates.
     *
     * @return array<array> list of test dates for the holiday defined in this test
     */
    public function SubstituteHolidayDataProvider(): array
    {
        return [
            [1975, null],
            [2005, null],
            [2020, null],
            [2021, null],
            [2022, null],
            [2023, '2023-05-29'],
            [2024, null],
            [2025, '2025-05-06'],
            [2026, '2026-05-25'],
            [2027, null],
            [2028, null],
            [2029, '2029-05-21'],
            [2030, null],
            [2031, null],
            [2032, '2032-05-17'],
            [2036, '2036-05-06'],
        ];
    }
}
