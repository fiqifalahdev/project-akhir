import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Users({ auth }) {
    return (
        <Authenticated user={auth.user}>
            <Head title="Informasi Pengguna Aplikasi" />

            <h1 className="my-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">
                Informasi Pengguna Aplikasi
            </h1>
        </Authenticated>
    );
}
