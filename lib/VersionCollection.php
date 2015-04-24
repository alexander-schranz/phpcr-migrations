<?php
/*
 * This file is part of the <package> package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\PhpcrMigrations;

class VersionCollection
{
    private $versions;

    public function __construct(array $versions)
    {
        ksort($versions, SORT_STRING);
        $this->versions = $versions;
    }

    public function has($versionTimestamp)
    {
        return isset($this->versions[$versionTimestamp]);
    }

    public function toArray()
    {
        return $this->versions;
    }

    public function getVersions($from, $to) 
    {
        $from = (string) $from;
        $to = (string) $to;
        $direction = $from > $to ? 'down' : 'up';
        $result = array();
        $versions = $this->versions;

        if ($direction === 'up') {
            ksort($versions, SORT_STRING);
        } else {
            krsort($versions, SORT_STRING);
        }

        $found = false;
        foreach ($versions as $timestamp => $version) {
            if ($timestamp == $from) {
                $found = true;

                if ($direction == 'down') {
                    $result[$timestamp] = $version;
                }

                continue;
            }

            if (false === $found) {
                continue;
            }


            if ($timestamp == $to) {
                if ($direction == 'up') {
                    $result[$timestamp] = $version;
                }
                break;
            }

            $result[$timestamp] = $version;
        }

        return $result;
    }

    public function getLatestVersion()
    {
        return end($this->versions);
    }
}