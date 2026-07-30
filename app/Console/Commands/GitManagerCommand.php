<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GitManagerCommand extends Command
{
    protected $signature = 'git:manager';

    protected $description = 'Git Repository Manager';

    public function handle()
    {
        while (true) {

            $this->clearScreen();

            $this->showHeader();

            $this->line('1.  Git Status');
            $this->line('2.  Git Pull');
            $this->line('3.  Git Push');
            $this->line('4.  Commit + Push');
            $this->line('5.  Release Baru');
            $this->line('6.  Update Release');
            $this->line('7.  Lihat Tag');
            $this->line('8.  Hapus Tag');
            $this->line('9.  Reset Perubahan Lokal');
            $this->line('10. Sync Ulang dari GitHub');
            $this->line('11. Ganti Branch');
            $this->line('12. Daftar Branch');
            $this->line('13. Git Log (10 Commit Terakhir)');
            $this->line('14. Auto Release');
            $this->line('15. Exit');

            $this->newLine();

            $menu = $this->ask('Pilih Menu');

            switch ($menu) {

                // ==================================
                // STATUS
                // ==================================
                case 1:

                    passthru('git status');

                    break;

                    // ==================================
                    // PULL
                    // ==================================
                case 2:

                    passthru('git pull');

                    break;

                    // ==================================
                    // PUSH
                    // ==================================
                case 3:

                    passthru('git push');

                    break;

                    // ==================================
                    // COMMIT + PUSH
                    // ==================================
                case 4:

                    $msg = $this->ask('Commit Message');

                    if (! $msg) {

                        $this->error(
                            'Commit message wajib diisi.'
                        );

                        break;
                    }

                    $msg = escapeshellarg($msg);

                    passthru('git add .');

                    passthru(
                        "git commit -m {$msg}"
                    );

                    passthru('git push');

                    $this->info(
                        'Commit dan Push berhasil.'
                    );

                    break;

                    // ==================================
                    // RELEASE BARU
                    // ==================================
                case 5:

                    $version = $this->ask(
                        'Versi Baru (contoh: v1.0.3)'
                    );

                    if (! $version) {

                        $this->error(
                            'Versi wajib diisi.'
                        );

                        break;
                    }

                    $check = trim(
                        shell_exec(
                            "git tag -l {$version}"
                        )
                    );

                    if ($check) {

                        $this->error(
                            "Tag {$version} sudah ada."
                        );

                        break;
                    }

                    passthru(
                        "git tag {$version}"
                    );

                    passthru(
                        "git push origin {$version}"
                    );

                    $this->info(
                        "Release {$version} berhasil dibuat."
                    );

                    break;

                    // ==================================
                    // UPDATE RELEASE
                    // ==================================
                case 6:

                    $version = $this->ask(
                        'Versi yang akan diupdate'
                    );

                    if (! $version) {

                        $this->error(
                            'Versi wajib diisi.'
                        );

                        break;
                    }

                    $confirm = $this->confirm(
                        "Update tag {$version} dengan force?"
                    );

                    if (! $confirm) {

                        break;
                    }

                    passthru(
                        "git tag -f {$version}"
                    );

                    passthru(
                        "git push --force origin {$version}"
                    );

                    $this->info(
                        "Release {$version} berhasil diupdate."
                    );

                    break;

                    // ==================================
                    // LIHAT TAG
                    // ==================================
                case 7:

                    passthru(
                        'git fetch --tags'
                    );

                    passthru(
                        'git tag'
                    );

                    break;

                    // ==================================
                    // HAPUS TAG
                    // ==================================
                case 8:

                    $version = $this->ask(
                        'Tag yang akan dihapus'
                    );

                    if (! $version) {

                        $this->error(
                            'Tag wajib diisi.'
                        );

                        break;
                    }

                    $confirm = $this->confirm(
                        "Hapus tag {$version}?"
                    );

                    if (! $confirm) {

                        break;
                    }

                    passthru(
                        "git tag -d {$version}"
                    );

                    passthru(
                        "git push origin :refs/tags/{$version}"
                    );

                    $this->info(
                        "Tag {$version} berhasil dihapus."
                    );

                    break;

                    // ==================================
                    // RESET PERUBAHAN LOKAL
                    // ==================================
                case 9:

                    $confirm = $this->confirm(
                        'SEMUA perubahan lokal akan dihapus. Lanjutkan?'
                    );

                    if (! $confirm) {

                        break;
                    }

                    passthru(
                        'git reset --hard'
                    );

                    passthru(
                        'git clean -fd'
                    );

                    $this->info(
                        'Semua perubahan lokal berhasil dihapus.'
                    );

                    break;

                    // ==================================
                    // SYNC ULANG DARI GITHUB
                    // ==================================
                case 10:

                    $branch = $this->getCurrentBranch();

                    $confirm = $this->confirm(
                        "Repository akan disamakan dengan GitHub branch [{$branch}]. Semua perubahan lokal hilang. Lanjutkan?"
                    );

                    if (! $confirm) {

                        break;
                    }

                    passthru(
                        'git fetch origin'
                    );

                    passthru(
                        "git reset --hard origin/{$branch}"
                    );

                    passthru(
                        'git clean -fd'
                    );

                    $this->info(
                        "Repository berhasil disinkronkan dengan origin/{$branch}"
                    );

                    break;

                    // ==================================
                    // GANTI BRANCH
                    // ==================================
                case 11:

                    passthru(
                        'git branch'
                    );

                    $branch = $this->ask(
                        'Masukkan nama branch tujuan'
                    );

                    if (! $branch) {

                        $this->error(
                            'Branch wajib diisi.'
                        );

                        break;
                    }

                    $confirm = $this->confirm(
                        "Pindah ke branch {$branch}?"
                    );

                    if (! $confirm) {

                        break;
                    }

                    passthru(
                        "git checkout {$branch}"
                    );

                    $this->info(
                        "Berhasil pindah ke branch {$branch}"
                    );

                    break;

                    // ==================================
                    // DAFTAR BRANCH
                    // ==================================
                case 12:

                    $this->info(
                        'Daftar Branch Lokal:'
                    );

                    passthru(
                        'git branch'
                    );

                    $this->newLine();

                    $this->info(
                        'Daftar Branch Remote:'
                    );

                    passthru(
                        'git branch -r'
                    );

                    break;

                    // ==================================
                    // GIT LOG
                    // ==================================
                case 13:

                    passthru(
                        'git log --oneline -10'
                    );

                    break;

                    // ==================================
                    // AUTO RELEASE
                    // ==================================
                case 14:

                    $branch = $this->getCurrentBranch();

                    $this->info(
                        "Branch aktif : {$branch}"
                    );

                    $status = trim(
                        shell_exec(
                            'git status --porcelain'
                        )
                    );

                    if (! $status) {

                        $this->warn(
                            'Tidak ada perubahan untuk direlease.'
                        );

                        break;
                    }

                    $this->line('');
                    $this->info(
                        'Perubahan ditemukan:'
                    );

                    passthru(
                        'git status --short'
                    );

                    $confirm = $this->confirm(
                        'Lanjutkan proses Auto Release?'
                    );

                    if (! $confirm) {

                        break;
                    }

                    $message = $this->ask(
                        'Commit Message'
                    );

                    if (! $message) {

                        $message = "Update aplikasi {$branch}";
                    }

                    $version = $this->ask(
                        'Versi Release (contoh: v1.0.3)'
                    );

                    if (! $version) {

                        $this->error(
                            'Versi release wajib diisi.'
                        );

                        break;
                    }

                    $checkTag = trim(
                        shell_exec(
                            "git tag -l {$version}"
                        )
                    );

                    if ($checkTag) {

                        $this->error(
                            "Tag {$version} sudah ada."
                        );

                        break;
                    }

                    $message = escapeshellarg(
                        $message
                    );

                    // Add file

                    passthru(
                        'git add .'
                    );

                    // Commit

                    passthru(
                        "git commit -m {$message}"
                    );

                    // Push branch

                    passthru(
                        "git push origin {$branch}"
                    );

                    // Create tag

                    passthru(
                        "git tag {$version}"
                    );

                    // Push tag

                    passthru(
                        "git push origin {$version}"
                    );

                    $this->info(
                        "Auto Release {$version} berhasil."
                    );

                    break;

                    // ==================================
                    // EXIT
                    // ==================================
                case 15:

                    $this->info(
                        'Keluar Git Manager.'
                    );

                    return Command::SUCCESS;

                default:

                    $this->error(
                        'Menu tidak tersedia.'
                    );

            }

            $this->newLine();

            $this->pause();

        }

    }

    /**
     * Header
     */
    private function showHeader()
    {

        $branch = $this->getCurrentBranch();

        $this->info(
            '=============================================='
        );

        $this->info(
            '          MASTER WEBADMIN GIT MANAGER'
        );

        $this->info(
            '=============================================='
        );

        $this->line(
            " Branch Aktif : {$branch}"
        );

        $this->newLine();

    }

    /**
     * Mendapatkan branch aktif
     */
    private function getCurrentBranch()
    {

        return trim(
            shell_exec(
                'git branch --show-current'
            )
        );

    }

    /**
     * Pause
     */
    private function pause()
    {

        $this->ask(
            'Tekan ENTER untuk kembali'
        );

    }

    /**
     * Clear terminal screen
     */
    private function clearScreen()
    {

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

            system('cls');

        } else {

            system('clear');

        }

    }
}
