<?php

namespace App\Http\Controllers;

use App\Models\MasterGajiPokok;
use Illuminate\Http\Request;

class MasterGajiPokokController extends Controller
{
    private function generateKenaikan()
    {
        $master = MasterGajiPokok::all();

        foreach ($master as $key => $value) {
            $besaran_awal = $value->besaran_nilai;
            $result_besaran = [];
            for ($a = 0; $a < $value->jumlah; $a++) {
                $b = [];
                if ($a == 0) {
                    $b[0] = (int)$besaran_awal;
                } else {
                    $b[] = $result_besaran[$a - 1][2];
                }

                for ($i = 0; $i < 22; $i++) {
                    if ($i == 0) {
                        $result_besaran[$a][0] =  (int)$b[0];
                    } else {
                        $result_besaran[$a][] = $result_besaran[$a][$i - 1] + ($besaran_awal * 0.053);
                    }
                }
            }
            $value->hasil_besaran = $result_besaran;
        }

        echo '<table>'
            . '<thead>'
            . '<tr>'
            . '<th>Golongan</th>'
            . '<th>1</th>'
            . '<th>2</th>'
            . '<th>3</th>'
            . '<th>4</th>'
            . '<th>5</th>'
            . '<th>6</th>'
            . '<th>7</th>'
            . '<th>8</th>'
            . '<th>9</th>'
            . '<th>10</th>'
            . '<th>11</th>'
            . '<th>12</th>'
            . '<th>13</th>'
            . '<th>14</th>'
            . '<th>15</th>'
            . '<th>16</th>'
            . '<th>17</th>'
            . '<th>18</th>'
            . '<th>19</th>'
            . '<th>20</th>'
            . '<th>21</th>'
            . '<th>22</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($master as $key => $value) {
            foreach ($value->hasil_besaran as $key2 => $value2) {
                $idx = $key2 + 6;
                echo '<tr>'
                    . '<td>' . $value->golongan . '-' . $idx . '</td>';
                foreach ($value2 as $key3 => $value3) {
                    echo '<td>' . $value3 . '</td>';
                }
                echo '</tr>';
            }
        }
        echo '</tbody>'
            . '</table>';
    }

    public function index()
    {
        $this->generateKenaikan();
    }
}
