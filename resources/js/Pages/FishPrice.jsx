import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function FishPrice({ auth }) {
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Daftar Harga Ikan" />

            <div className="flex h-[80vh] my-6 justify-center items-center flex-col">
                <h2 className="text-3xl dark:text-gray-200 mb-4">
                    Mohon Maaf, Halaman Ini Sedang Dalam Pengembangan
                </h2>
                <a
                    href="https://fishinfojatim.net/HargaPedagang"
                    className=" text-2xl font-semibold text-gray-800 dark:text-indigo-300 hover:text-indigo-400 transition-colors"
                    target="_blank"
                >
                    Lihat Info Harga Ikan di Sini
                </a>
            </div>
        </AuthenticatedLayout>
    );
}
