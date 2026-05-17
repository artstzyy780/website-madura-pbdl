<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->decimal('saldo_hutang', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_nota')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_pembeli')->nullable(); // bisa tanpa pelanggan terdaftar
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggan')->nullOnDelete();
            $table->enum('metode_bayar', ['cash', 'hutang', 'gopay', 'dana', 'qris', 'bca', 'seabank', 'mandiri'])->default('cash');
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['lunas', 'hutang'])->default('lunas');
            $table->boolean('is_draft')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('transaksi_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->cascadeOnDelete();
            $table->foreignId('produk_id')->constrained('produk');
            $table->string('kode_barang');
            $table->string('nama_produk');
            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaksi_item');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('pelanggan');
    }
};
