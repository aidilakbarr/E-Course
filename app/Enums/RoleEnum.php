<?php
namespace App\Enums;
enum RoleEnum: string
{
    case ADMIN = 'ADMIN';
    case KAPRODI = 'KAPRODI';
    case DOSEN = 'DOSEN';
    case MAHASISWA = 'MAHASISWA';
}