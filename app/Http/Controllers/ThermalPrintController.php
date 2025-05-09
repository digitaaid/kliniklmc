<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;

class ThermalPrintController extends Controller
{
    public function cekThermalPrinter(Request $request)
    {
        if (empty($request->printer_connector)) {
            $request['printer_connector'] = "EPSON TM-T82X Receipt";
        }
        return view('admin.thermal_printer', compact([
            'request',
        ]));
    }
    public function testThermalPrinter(Request $request)
    {
        $data = "TOKO ALFAMART";
        try {
            $connector = new WindowsPrintConnector($request->printer_connector);
            // $connector = new WindowsPrintConnector("EPSON TM-T82X Receipt");
            // $connector = new NetworkPrintConnector("192.168.2.201", 9100);
            $printer = new Printer($connector);
            $printer->text("Test Printer\n");
            $printer->text("Printer Connector : " . $request->printer_connector . "\n");
            $printer->barcode('BARCODE');
            $printer->qrCode('QRCODE');
            $printer->setEmphasis(true);
            $printer->text($data . "\n");
            $printer->setEmphasis(false);
            $printer->text("setEmphasis false\n");
            $printer->setFont(2);
            $printer->text("setFont 2\n");
            $printer->setFont(1);
            $printer->text("setFont 1\n");
            $printer->setFont(0);
            $printer->text("setFont 0\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("setJustification JUSTIFY_RIGHT\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("setJustification JUSTIFY_CENTER\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("setJustification JUSTIFY_LEFT\n");
            for ($i = 1; $i <= 8; $i++) {
                $printer->setTextSize($i, $i);
                $printer->text($i . "\n");
            }
            $printer->cut();
            $printer->close();
            Alert::success('Success', 'Test Printer Berhasil');
        } catch (Exception $e) {
            Alert::error('Error', 'Test Printer Error ' . $e->getMessage());
        }


        return redirect()->route('cekThermalPrinter');
    }
    public function cekPrinter()
    {
        try {
            $connector = new WindowsPrintConnector(env('PRINTER_CHECKIN'));
            $printer = new Printer($connector);
            $printer->text("Connector Printer :\n");
            $printer->text(env('PRINTER_CHECKIN') . "\n");
            $printer->text("Test Printer Berhasil.\n");
            $printer->cut();
            $printer->close();
            Alert::success('Success', 'Mesin menyala dan siap digunakan.');
            return redirect()->route('antrianConsole');
        } catch (\Throwable $th) {
            // throw $th;
            Alert::error('Error', 'Mesin antrian tidak menyala. Silahkan hubungi admin.');
            return redirect()->route('antrianConsole');
        }
    }
    public function testprinterthermal()
    {
        return view('sim.test_printer_thermal');
    }
}
