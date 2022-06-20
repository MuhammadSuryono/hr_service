<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Controller
{

    /**
     * @var Request
     */
    protected Request $request;

    public array $convNumberToRomanNumber = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    public array $convMonthIntlToIndonesian = [
        "Jan" => "Januari",
        "Feb" => "Februari",
        "Mar" => "Maret",
        "Apr" => "April",
        "May" => "Mei",
        "Jun" => "Juni",
        "Jul" => "Juli",
        "Aug" => "Agustus",
        "Sep" => "September",
        "Oct" => "Oktober",
        "Nov" => "November",
        "Dec" => "Desember",
    ];

    protected int $defaultLimit = 10;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $status
     * @param int $code
     * @param string $message
     * @param $data
     * @return object
     */
    public function callback_response(string $status = "success", int $code = 200, string $message = '', $data = null): object
    {
        return (object)[
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLimitPage()
    {
        return request()->has('limit') ? request()->get('limit') : $this->defaultLimit;
    }

    /**
     * @return string[]
     */
    public function dict_day_local(): array
    {
        return [
            "Minggu" => "Sunday",
            "Senin" => "Monday",
            "Selasa" => "Tuesday",
            "Rabu" => "Wednesday",
            "Kamis" => "Thursday",
            "Jumat" => "Friday",
            "Sabtu" => "Saturday",
        ];
    }

    /**
     * @return Request
     */
    public function request_data(): Request
    {
        return $this->request;
    }

    /**
     * @param $date
     * @return string
     */
    public function conv_date_to_indonesia_format($date): string
    {
        $dayNumber = date('d', strtotime($date));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));

        return sprintf('%s %s %s', $dayNumber, $this->convMonthIntlToIndonesian[$month], $year);
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->request->get("page", 1);
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get_query_url(string $key, string $default = "")
    {
        return $this->request->get($key, $default);
    }

    /**
     * @return mixed
     */
    public function user_division()
    {
        return auth()->user()->divisi;
    }

    /**
     * @return mixed
     */
    public function user_level()
    {
        return auth()->user()->level;
    }
}
