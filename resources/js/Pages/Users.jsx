import Paginator from "@/Components/Paginator";
import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Users({ auth, users }) {
    console.log(users);
    return (
        <Authenticated user={auth.user}>
            <Head title="Informasi Pengguna Aplikasi" />

            <h2 className="my-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">
                Informasi Pengguna Aplikasi
            </h2>

            <div className="w-full overflow-hidden rounded-lg shadow-xs mb-5">
                <div className="w-full overflow-x-auto">
                    <table className="w-full whitespace-no-wrap">
                        <thead>
                            <tr className="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th className="px-4 py-3">Nama Pengguna</th>
                                <th className="px-4 py-3">Peran Pengguna</th>
                                <th className="px-4 py-3">Status</th>
                                <th className="px-4 py-3">Nomor Telepon</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            {users.data.map((user) => (
                                <tr className="text-gray-700 dark:text-gray-400">
                                    <td className="px-4 py-3">{user.name}</td>
                                    <td className="px-4 py-3">{user.role}</td>
                                    <td className="px-4 py-3">
                                        <span className="text-green-500">
                                            •
                                        </span>{" "}
                                        Aktif
                                    </td>
                                    <td className="px-4 py-3">{user.phone}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                <Paginator meta={users} />
            </div>
        </Authenticated>
    );
}
