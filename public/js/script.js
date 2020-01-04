$(function() {

  $('.tombolTambahData').on('click', function(){

    $('#formModalLabel').html('Tambah Data Mahsiswa')
    $('.modal-footer button[type=submit]').html('tambah Data');

    $('.tombolTambahData').on('click', function() {
      $('#formModalLabel').html('Tambah Data Mahasiswa');
      $('.modal-footer button[type=submit]').html('Tambah Data');
      $('#nama').val('');
      $('#nrp').val('');
      $('#email').val('');
      $('#jurusan').val('');
      $('#id').val('');
  });
});

$('.tampilModalUbah').on('click', function(){

  $('#formModalLabel').html('Ubah Data Mahsiswa')
  $('.modal-footer button[type=submit]').html('ubah Data');
  $('.modal-body form').attr('action', 'http://localhost:8080/skripsiFPGrowth/public/mahasiswa/ubah');

  const id = $(this).data('id');

//menjalankan ajax
$.ajax({
    url:'http://localhost:8080/skripsiFPGrowth/public/mahasiswa/getubah',
    data: {id : id },
    method: 'post',
    dataType: 'json',
    success: function (data) {
      $('#nama').val(data.nama);
      $('#nrp').val(data.nrp);
      $('#email').val(data.email);
      $('#jurusan').val(data.jurusan);
      $('#id').val(data.id);
    }
    });
});

});
