<!DOCTYPE html>
<html lang="en" class="bg-white">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lowongan</title>
    <link rel="stylesheet" href="css/output.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
</head>

<body>
    <div class="navbar bg-base-100">
        <a class="btn btn-ghost text-xl">
            Sehatea
            <img src="img/1.png" class="h-full rounded-full" alt="logo" /></a>
    </div>
    <!-- navbar end -->

    <div class="container p-10 mx-auto">
        <p class="text-1xl lg:text-3xl text-slate-900">
            Selamat datang, silahkan isi formulir berikut ini untuk melamar.
        </p>
    </div>

    <!-- form pengisian data -->
    <div class="container p-10 mx-auto">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form id="formLowongan" action="simpan.php" method="post">
                    <h2 class="card-title mb-7">Formulir lowongan</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- nama -->
                        <input type="text" id="nama" name="nama" required placeholder="Masukan nama" class="input input-bordered input-success mb-5 w-full max-w-xs" />
                        <!-- usia -->
                        <input type="number" id="usia" name="usia" required placeholder="Masukan usia anda" class="input input-bordered input-success mb-5 w-full max-w-xs" />
                        <!-- nohp -->
                        <input type="number" id="nomor" name="nomor" required placeholder="Masukan nomor hp" class="input input-bordered input-success mb-5 w-full max-w-xs" />
                        <!-- pengalaman ? -->
                        <div>
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Berpengalaman kerja</span>
                                    <input id="y_pengalaman" type="radio" name="pengalaman" value="ya" class="radio checked:bg-green-700" required />
                                </label>
                            </div>
                            <div class="form-control mb-5">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Tidak Berpengalaman kerja</span>
                                    <input id="t_pengalaman" type="radio" name="pengalaman" value="tidak" class="radio checked:bg-blue-400" required />
                                </label>
                            </div>
                        </div>
                        <!-- jenis kelamin -->
                        <select id="jk" name="jk" class="select select-success mb-5 w-full max-w-xs" required>
                            <option disabled selected>Jenis Kelamin</option>
                            <option value="l">Laki - Laki</option>
                            <option value="p">Perempuan</option>
                        </select>

                        <textarea id="alamat" name="alamat" class="textarea textarea-success mb-5 w-full max-w-xs" required placeholder="Masukan Alamat"></textarea>
                    </div>
                    <!-- pengalaman -->
                    <div id="isi_pengalaman" class="form-control hidden w-full">
                        <div class="label">
                            <span class="label-text">Sebutkan pengalaman anda ?</span>
                        </div>
                        <input type="text" id="pengalaman" name="pengalaman_detail" placeholder="Contoh : Jaga Stand, Jaga Toko, Kurir, dll." class="input input-bordered input-success mb-5 w-full max-w-xs" />
                    </div>
                    <!-- submit -->
                    <div class="card-actions justify-end mt-10">
                        <button type="submit" name="btn_simpan" class="btn btn-primary">
                            Kirimkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- container end -->

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {


            // Periksa apakah status pengiriman sudah tersimpan di local storage
            var submissionStatus = localStorage.getItem('submissionStatus');
            if (submissionStatus === 'submitted') {
                // Jika sudah, arahkan pengguna langsung ke halaman terimakasih.php
                window.location.href = "terimakasih.php";
            }


            const yp = $("#y_pengalaman");
            const tp = $("#t_pengalaman");
            const boxPengalaman = $("#isi_pengalaman");


            yp.change(function() {
                if ($(this).is(":checked")) {
                    showBox();
                } else {
                    hideBox();
                }
            });

            tp.change(function() {
                if ($(this).is(":checked")) {
                    hideBox();
                } else {
                    showBox();
                }
            });
        });

        function showBox() {
            $("#isi_pengalaman").removeClass("hidden");
        }

        function hideBox() {
            $("#isi_pengalaman").addClass("hidden");
        }

        // logic form
        $("#formLowongan").submit(function(event) {
            event.preventDefault();

            var formData = {
                nama: $("#nama").val(),
                usia: $("#usia").val(),
                jk: $("select[name='jk']").val(),
                pengalaman: $("input[name='pengalaman']:checked").val(),
                pengalaman_detail: $("#pengalaman").val(),
                alamat: $("#alamat").val(),
                nomor: $("#nomor").val()
            };

            $.ajax({
                type: "POST",
                url: "simpan.php",
                data: formData,
                dataType: "json",
                encode: true,
                success: function(response) {
                    // alert("Data berhasil disimpan!");
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Laran anda berhasil di kirimkan !",
                        showConfirmButton: false,
                        timer: 1500
                    });



                    // Reset form
                    $("#formLowongan")[0].reset();

                    // Simpan status pengiriman pada local storage
                    localStorage.setItem('submissionStatus', 'submitted');

                    setTimeout(function() {
                        window.location.href = "terimakasih.php";
                    }, 1500);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            });
        });
    </script>
</body>

</html>