<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collLab">
        <h3 class="card-title">
            E-Laboratorium
        </h3>
    </a>

    <div id="collLab" class="collapse" role="tabpanel" aria-labelledby="headLab">
        <div class="card-body">
            <form action="{{ route('permintaanlab') }}" method="POST">
                @csrf
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan_id }}">
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kodekunjungan }}">
                <input type="hidden" name="kode" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="waktu" value="{{ now() }}">
                <input type="hidden" name="norm" value="{{ $antrian->kunjungan->norm }}">
                <input type="hidden" name="nama" value="{{ $antrian->kunjungan->nama }}">
                <div class="row">
                    <div class="col-md-3">
                        <u><b>HEMATOLOGI</b></u><br>
                        <b>RUTIN</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="hemalengkap" name="permintaan_lab[]"
                                value="hemalengkap">
                            <label for="hemalengkap" class="custom-control-label">Hematologi Lengkap *
                                Diffcount</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="led" name="permintaan_lab[]"
                                value="led">
                            <label for="led" class="custom-control-label">LED (Laju
                                Endap Darah)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="adt" name="permintaan_lab[]"
                                value="adt">
                            <label for="adt" class="custom-control-label">ADT (Apus
                                Darah Tepi)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="let" name="permintaan_lab[]"
                                value="let">
                            <label for="let" class="custom-control-label">LE
                                Test</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="si" name="permintaan_lab[]"
                                value="si">
                            <label for="si" class="custom-control-label">SI (Serum
                                Iron / Fe)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="tibc" name="permintaan_lab[]"
                                value="tibc">
                            <label for="tibc" class="custom-control-label">TIBC</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="fer" name="permintaan_lab[]"
                                value="fer">
                            <label for="fer" class="custom-control-label">Ferritin</label>
                        </div>
                        <u><b>KLINIK URINE</b></u><br>
                        <b>URINE</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="urine_rutin" name="permintaan_lab[]"
                                value="urine_rutin">
                            <label for="urine_rutin" class="custom-control-label">Urine
                                Rutin</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <u><b>KIMIA DARAH</b></u><br>
                        <b>KARBOHIDRAT</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="glukosa_puasa"
                                name="permintaan_lab[]" value="glukosa_puasa">
                            <label for="glukosa_puasa" class="custom-control-label">Glukosa
                                Puasa *</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="glukosa_2jampp"
                                name="permintaan_lab[]" value="glukosa_2jampp">
                            <label for="glukosa_2jampp" class="custom-control-label">Glukosa
                                2 Jam PP</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="glukosa_sewaktu"
                                name="permintaan_lab[]" value="glukosa_sewaktu">
                            <label for="glukosa_sewaktu" class="custom-control-label">Glukosa
                                Sewaktu</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="aba1c"
                                name="permintaan_lab[]" value="aba1c">
                            <label for="aba1c" class="custom-control-label">ABA1C</label>
                        </div>
                        <b>FAAL HATI</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="sgot"
                                name="permintaan_lab[]" value="sgot">
                            <label for="sgot" class="custom-control-label">SGOT</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="sgpt"
                                name="permintaan_lab[]" value="sgpt">
                            <label for="sgpt" class="custom-control-label">SGPT</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="alkali_fosfatase"
                                name="permintaan_lab[]" value="alkali_fosfatase">
                            <label for="alkali_fosfatase" class="custom-control-label">Alkali
                                Fosfatase</label>
                        </div>
                        <b>FAAL GINJAL</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ureum_bun"
                                name="permintaan_lab[]" value="ureum_bun">
                            <label for="ureum_bun" class="custom-control-label">Ureum /
                                BUN</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="creatinin"
                                name="permintaan_lab[]" value="creatinin">
                            <label for="creatinin" class="custom-control-label">Creatinin</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="asam_urat"
                                name="permintaan_lab[]" value="asam_urat">
                            <label for="asam_urat" class="custom-control-label">Asam
                                Urat *</label>
                        </div>
                        <b>LEMAK</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="cholestrol_total"
                                name="permintaan_lab[]" value="cholestrol_total">
                            <label for="cholestrol_total" class="custom-control-label">Cholestrol Total*</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="trigliseida"
                                name="permintaan_lab[]" value="trigliseida">
                            <label for="trigliseida" class="custom-control-label">Trigliserida* Puasa 12-16
                                Jam</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="hdl_cholestrol"
                                name="permintaan_lab[]" value="hdl_cholestrol">
                            <label for="hdl_cholestrol" class="custom-control-label">HDL Cholesterol</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ldi_cholestrol"
                                name="permintaan_lab[]" value="ldi_cholestrol">
                            <label for="ldi_cholestrol" class="custom-control-label">LDI Cholesterol</label>
                        </div>
                        <b>FAAL JANTUNG</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ldh"
                                name="permintaan_lab[]" value="ldh">
                            <label for="ldh" class="custom-control-label">LDH</label>
                        </div>
                        <b>ELEKTROLIT DAN GAN DARAH</b><br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="natrium"
                                name="permintaan_lab[]" value="natrium">
                            <label for="natrium" class="custom-control-label">Natrium</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="kalium"
                                name="permintaan_lab[]" value="kalium">
                            <label for="kalium" class="custom-control-label">Kalium</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="calcium"
                                name="permintaan_lab[]" value="calcium">
                            <label for="calcium" class="custom-control-label">Calcium</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <u><b>IMUNOSEROLOGI DAN SEROLOGI</b></u><br>
                        <b>HEPATITIS</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="hiisag_rapid"
                                name="permintaan_lab[]" value="hiisag_rapid">
                            <label for="hiisag_rapid" class="custom-control-label">HIIsAg Rapid</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="anti_hcv"
                                name="permintaan_lab[]" value="anti_hcv">
                            <label for="anti_hcv" class="custom-control-label">Anti HCV</label>
                        </div>
                        <b>PENANDA TUMOR</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="cea"
                                name="permintaan_lab[]" value="cea">
                            <label for="cea" class="custom-control-label">CEA</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="afp"
                                name="permintaan_lab[]" value="afp">
                            <label for="afp" class="custom-control-label">AFP</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ca125"
                                name="permintaan_lab[]" value="ca125">
                            <label for="ca125" class="custom-control-label">Ca 125</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ca153"
                                name="permintaan_lab[]" value="ca153">
                            <label for="ca153" class="custom-control-label">Ca 15-3</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ca199"
                                name="permintaan_lab[]" value="ca199">
                            <label for="ca199" class="custom-control-label">Ca 19-9</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="fas_total"
                                name="permintaan_lab[]" value="fas_total">
                            <label for="fas_total" class="custom-control-label">FSA Total</label>
                        </div>
                        <b>HORMON</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="t3"
                                name="permintaan_lab[]" value="t3">
                            <label for="t3" class="custom-control-label">T3</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="f4"
                                name="permintaan_lab[]" value="f4">
                            <label for="f4" class="custom-control-label">f4</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ft4"
                                name="permintaan_lab[]" value="ft4">
                            <label for="ft4" class="custom-control-label">FT4</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="t5hs"
                                name="permintaan_lab[]" value="t5hs">
                            <label for="t5hs" class="custom-control-label">T5Hs</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="beta_hcg"
                                name="permintaan_lab[]" value="beta_hcg">
                            <label for="beta_hcg" class="custom-control-label">Beta HCG</label>
                        </div>
                        <b>RHEUMATIK & PROTEIN SPESIFIK</b> <br>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="crp_kuantitatif"
                                name="permintaan_lab[]" value="crp_kuantitatif">
                            <label for="crp_kuantitatif" class="custom-control-label">CRP Kuantitatif</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ana_test"
                                name="permintaan_lab[]" value="ana_test">
                            <label for="ana_test" class="custom-control-label">ANA Test</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="antids-dns"
                                name="permintaan_lab[]" value="antids-dns">
                            <label for="antids-dns" class="custom-control-label">Anti-ds DNA</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Permintaan Laboratorium"
                            name="catatan" placeholder="Catatan Permintaan Laboratorium">
                            {{ $kunjungan->asesmendokter->catatan ?? null }}
                        </x-adminlte-textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-diagnoses"></i> Submit Permintaan
                    Lab</button>
            </form>

        </div>
    </div>
</div>
