import GoogleMapsLink from "@/Components/GoogleMapsLink";
import Paginator from "@/Components/Paginator";
import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, usePage } from "@inertiajs/react";
import "boxicons";
// import FishMarketCreate from "./FishMarketCreate";

const FishMarket = ({ auth, data }) => {
    const { flash } = usePage().props;

    const closeAlert = () => {
        window.location.reload();
    };

    const deleteData = (id) => {
        router.delete(route("delete-fish-market", { id: id }));
    };

    return (
        <Authenticated user={auth.user}>
            <Head title="Pasar Ikan" />

            <div className="flex justify-between w-full my-4">
                <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Pasar Ikan
                </h2>
                <div className="flex justify-center items-center">
                    <Link
                        href={route("add-fish-market")}
                        className="text-sm font-medium text-white bg-indigo-600 w-[100] h-[50px] p-4 rounded-md transition-colors duration-150 hover:bg-indigo-700"
                    >
                        Tambah
                    </Link>
                </div>
            </div>

            {/* DIsplaying Alert */}
            {flash.message ? (
                <div className="flex justify-start items-center w-full mb-4">
                    <div className="bg-green-500 p-4 rounded-md w-[400px] h-[60px] text-white text-center flex justify-between items-center">
                        {flash.message}
                        <button
                            className="flex items-center"
                            onClick={closeAlert}
                        >
                            <box-icon name="x" color="white"></box-icon>
                        </button>
                    </div>
                </div>
            ) : null}

            <div className="w-full overflow-hidden rounded-lg shadow-xs mb-5">
                <div className="w-full overflow-x-auto">
                    <table className="w-full whitespace-no-wrap">
                        <thead>
                            <tr className="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th className="px-4 py-3">Nama Pasar</th>
                                <th className="px-4 py-3">Alamat</th>
                                <th className="px-4 py-3">Lokasi</th>
                                <th className="px-4 py-3">Nomor Telepon</th>
                                <th className="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            {data.data.map((element, index) => {
                                return (
                                    <tr
                                        key={index}
                                        className="text-gray-700 dark:text-gray-400"
                                    >
                                        <td className="px-4 py-3 text-sm">
                                            <div className="flex items-center text-sm">
                                                <p>{element.name}</p>
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-sm">
                                            <div className="flex items-center text-sm">
                                                <p>{element.address}</p>
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-sm">
                                            <div className="flex items-center text-sm">
                                                <GoogleMapsLink
                                                    longitude={
                                                        element.longitude
                                                    }
                                                    latitude={element.latitude}
                                                />
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-sm">
                                            <div className="flex items-center text-sm">
                                                <p>{element.phone}</p>
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-sm flex w-[130px] justify-between items-center">
                                            <div className="flex items-center text-sm">
                                                <Link
                                                    href={route(
                                                        "edit-fish-market",
                                                        { id: element.id }
                                                    )}
                                                    className="bg-teal-700 w-[40px] h-[40px] flex justify-center items-center rounded-md"
                                                >
                                                    <box-icon
                                                        name="edit-alt"
                                                        type="solid"
                                                        color="white"
                                                    ></box-icon>
                                                </Link>
                                            </div>
                                            <div className="flex items-center text-sm">
                                                <form
                                                    onSubmit={(e) => {
                                                        e.preventDefault();
                                                        deleteData(element.id);
                                                    }}
                                                >
                                                    <button
                                                        type="submit"
                                                        className="bg-red-700 w-[40px] h-[40px] flex justify-center items-center rounded-md"
                                                    >
                                                        <box-icon
                                                            name="trash"
                                                            type="solid"
                                                            color="white"
                                                        ></box-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
                <Paginator meta={data} />
            </div>
        </Authenticated>
    );
};

export default FishMarket;
