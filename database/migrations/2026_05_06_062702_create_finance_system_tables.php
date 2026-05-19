<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Keuangan (Income/Expense)
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pemasukan', 'pengeluaran']);
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->string('category');
            $table->string('reference_id')->nullable(); // Invoice number if automated
            $table->text('description')->nullable();
            $table->string('proof_image')->nullable();
            $table->timestamps();
        });

        // Tabel Hutang & Piutang
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hutang', 'piutang']);
            $table->string('name'); // Nama pihak terkait
            $table->decimal('amount', 15, 2);
            $table->decimal('total_paid', 15, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->enum('status', ['belum lunas', 'lunas'])->default('belum lunas');
            $table->timestamps();
        });

        // Tabel Riwayat Cicilan Hutang
        Schema::create('debt_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('debt_id')->constrained('debts')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_payments');
        Schema::dropIfExists('debts');
        Schema::dropIfExists('finances');
    }
};
