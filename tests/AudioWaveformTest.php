<?php

namespace Synchro\MediaLibrary\Conversions\ImageGenerators\Tests;

use Spatie\Snapshots\MatchesSnapshots;
use Synchro\MediaLibrary\Conversions\ImageGenerators\AudioWaveform;

class AudioWaveformTest extends TestCase
{
    use MatchesSnapshots;

    protected function tearDown(): void
    {
        foreach (glob(__DIR__ . '/testfiles/*.png') as $image) {
            unlink($image);
        }

        parent::tearDown();
    }

    /**
     * @test
     * @dataProvider audioFiles
     *
     * @param string $audioFilePath
     */
    public function itConvertsAudioFile(string $audioFilePath): void
    {
        $generator = new AudioWaveform();
        $imageFilePath = $generator->convert($audioFilePath);

        $this->assertStringEndsWith('.png', $imageFilePath);

        $this->assertMatchesFileSnapshot($imageFilePath);
    }

    /** @test */
    public function itConvertsAudioFileWithCustomColors(): void
    {
        $generator = new AudioWaveform([
            'foreground' => '#ffffff',
            'background' => '#000000',
        ]);
        $imageFilePath = $generator->convert(__DIR__ . '/testfiles/test_mp3.mp3');

        $this->assertStringEndsWith('.png', $imageFilePath);

        $this->assertMatchesFileSnapshot($imageFilePath);
    }

    /** @test */
    public function itConvertsAudioFileWithCustomDimensions(): void
    {
        $generator = new AudioWaveform([
            'width' => 2048,
            'height' => 512,
        ]);
        $imageFilePath = $generator->convert(__DIR__ . '/testfiles/test_mp3.mp3');

        $this->assertStringEndsWith('.png', $imageFilePath);

        $this->assertMatchesFileSnapshot($imageFilePath);
    }

    public function audioFiles(): array
    {
        return [
            'aiff' => [__DIR__ . '/testfiles/test_aiff.aiff'],
            'flac' => [__DIR__ . '/testfiles/test_flac.flac'],
            'm4a' => [__DIR__ . '/testfiles/test_m4a.m4a'],
            'mp3' => [__DIR__ . '/testfiles/test_mp3.mp3'],
            'ogg' => [__DIR__ . '/testfiles/test_ogg.ogg'],
            'wav' => [__DIR__ . '/testfiles/test_wav.wav'],
            'wma' => [__DIR__ . '/testfiles/test_wma.wma'],
        ];
    }
}
