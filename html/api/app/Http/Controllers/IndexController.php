<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CreditScoreTransformer;
use App\Services\HttpClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class IndexController
 *
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /** @var CreditScoreTransformer $creditScoreTransformerService */
    private $creditScoreTransformerService;

    /**
     * IndexController constructor.
     *
     * @param CreditScoreTransformer $creditScoreTransformer
     */
    public function __construct(CreditScoreTransformer $creditScoreTransformer)
    {
        $this->creditScoreTransformerService = $creditScoreTransformer;
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return View
     */
    public function testXml(HttpClient $httpClient): View
    {
        $data = $this->getTestData();
        $callResult = $httpClient->dummyXmlCall($data);
        return view('xml', ['xmlObject' => $callResult]);
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return JsonResponse
     */
    public function testJson(HttpClient $httpClient): JsonResponse
    {
        $data = $this->getTestData();
        $callResult = $httpClient->dummyJsonCall($data);
        return response()->json([
            $callResult
        ], Response::HTTP_OK);
    }

    /**
     * @return array
     */
    private function getTestData(): array
    {
        $data = [
            "firstName" => "Vasya",
            "lastName" => "Pupkin",
            "dateOfBirth" => "1984-07-31",
            "Salary" => "1000",
            "creditScore" => rand(0, 1) ? CreditScoreTransformer::SCORE_GOOD_KEY : CreditScoreTransformer::SCORE_BAD_KEY
        ];

        $data['creditScore'] = $this->creditScoreTransformerService->transform($data['creditScore']);
        return $data;
    }
}
