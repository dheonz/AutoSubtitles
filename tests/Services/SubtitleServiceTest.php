<?php
namespace Tests\Services;

use Mockery;
use Mockery\Mock;
use SubtitleProviders\OpenSubtitles\Provider as OpenSubtitlesProvider;
use SubtitleProviders\SubDb\Provider as SubDbProvider;
use Services\SubtitleService;

class SubtitleServiceTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldCallAllServiceProviders()
    {
        $fakeVideoFile = __DIR__ . 'some/fake/video/file.mp4';

        /** @var SubDbProvider|Mock $subDbProvider */
        $subDbProvider = Mockery::mock(SubDbProvider::class);
        $subDbProvider->shouldReceive('downloadSubtitleForVideoFile')
            ->once()
            ->with($fakeVideoFile);

        /** @var OpenSubtitlesProvider|Mock $openSubsProvider */
        $openSubsProvider = Mockery::mock(OpenSubtitlesProvider::class);
        $openSubsProvider->shouldReceive('downloadSubtitleForVideoFile')
            ->once()
            ->with($fakeVideoFile);

        $subtitleService = new SubtitleService($subDbProvider, $openSubsProvider);
        $subtitleService->downloadSubtitlesForVideoFile($fakeVideoFile);
    }

    /**
     * @test
     */
    public function shouldReportSuccessCount()
    {
        $fakeVideoFile = __DIR__ . 'some/fake/video/file.mp4';

        /** @var SubDbProvider|Mock $subDbProvider */
        $subDbProvider = Mockery::mock(SubDbProvider::class);
        $subDbProvider->shouldReceive('downloadSubtitleForVideoFile')
            ->andReturn(true);

        /** @var OpenSubtitlesProvider|Mock $openSubsProvider */
        $openSubsProvider = Mockery::mock(OpenSubtitlesProvider::class);
        $openSubsProvider->shouldReceive('downloadSubtitleForVideoFile')
            ->andReturn(false);

        $subtitleService = new SubtitleService($subDbProvider, $openSubsProvider);
        $successCount = $subtitleService->downloadSubtitlesForVideoFile($fakeVideoFile);
        $this->assertEquals(1, $successCount);
    }
}