<?php 

class HomePageAPITestCest
{
    /**
     * @test
     * @param ApiTester $I
     */
    public function weGetResponse(ApiTester $I)
    {
        $I->sendGET('');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
