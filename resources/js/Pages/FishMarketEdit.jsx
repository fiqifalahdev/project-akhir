import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, usePage } from "@inertiajs/react";

export default function FishMarkeEdit({ auth, market }) {
    console.log(market);

    const { data, setData, patch, processing, errors } = useForm({
        name: market.name,
        address: market.address,
        phone: market.phone,
        latitude: market.latitude,
        longitude: market.longitude,
    });

    const { flash } = usePage().props;

    const submit = (e) => {
        e.preventDefault();

        console.log(data);

        patch(route("update-fish-market", market.id));
    };

    const closeAlert = () => {
        window.location.reload();
    };

    return (
        <Authenticated user={auth.user}>
            <Head title="Tambah Pasar Ikan" />

            {/* back button */}
            <div className="flex justify-between w-full">
                <Link
                    href={route("fish-market")}
                    className="flex justify-center items-center text-sm font-medium text-white mt-6 hover:bg-indigo-500 w-[40px] h-[40px] rounded-md transition-colors"
                >
                    <box-icon name="arrow-back" color="white"></box-icon>
                </Link>
            </div>

            {/* DIsplaying Alert */}
            {flash.erorrs ? (
                <div className="flex justify-start items-center w-full mb-4">
                    <div className="bg-red-500 p-4 rounded-md w-[400px] h-[60px] text-white text-center flex justify-between items-center">
                        {flash.errors}
                        <button
                            className="flex items-center"
                            onClick={closeAlert}
                        >
                            <box-icon name="x" color="white"></box-icon>
                        </button>
                    </div>
                </div>
            ) : null}

            <div className="flex justify-between w-full mt-2">
                <h2 className="my-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Edit Data Pasar Ikan
                </h2>
            </div>

            <div className="w-full overflow-hidden rounded-lg shadow-xs mb-5">
                <form onSubmit={submit}>
                    <div className="p-6">
                        <div className="grid grid-cols-1 gap-6">
                            <div>
                                <label
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-200"
                                    htmlFor="name"
                                >
                                    Nama Pasar
                                </label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:ring"
                                    value={data.name}
                                    placeholder={market.name}
                                    onChange={(e) => {
                                        setData("name", e.target.value);
                                    }}
                                />

                                {/* Error message */}
                                <div className="text-red-500">
                                    {errors.name}
                                </div>
                            </div>
                            <div>
                                <label
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-200"
                                    htmlFor="address"
                                >
                                    Alamat
                                </label>
                                <input
                                    id="address"
                                    name="address"
                                    type="text"
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:ring"
                                    value={data.address}
                                    placeholder={market.address}
                                    onChange={(e) => {
                                        setData("address", e.target.value);
                                    }}
                                />

                                {/* Error message */}
                                <div className="text-red-500">
                                    {errors.address}
                                </div>
                            </div>
                            <div>
                                <label
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-200"
                                    htmlFor="phone"
                                >
                                    Nomor Telepon
                                </label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:ring"
                                    value={data.phone}
                                    placeholder={market.phone}
                                    onChange={(e) => {
                                        setData("phone", e.target.value);
                                    }}
                                />

                                {/* Error message */}
                                <div className="text-red-500">
                                    {errors.phone}
                                </div>
                            </div>
                            <div>
                                <label
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-200"
                                    htmlFor="latitude"
                                >
                                    Latitude
                                </label>
                                <input
                                    id="latitude"
                                    name="latitude"
                                    type="number"
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:ring"
                                    value={data.latitude}
                                    placeholder={market.latitude}
                                    onChange={(e) => {
                                        setData("latitude", e.target.value);
                                    }}
                                />

                                {/* Error message */}
                                <div className="text-red-500">
                                    {errors.latitude}
                                </div>
                            </div>
                            <div>
                                <label
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-200"
                                    htmlFor="longitude"
                                >
                                    Longitude
                                </label>
                                <input
                                    id="longitude"
                                    name="longitude"
                                    type="number"
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:ring"
                                    value={data.longitude}
                                    placeholder={market.longitude}
                                    onChange={(e) => {
                                        setData("longitude", e.target.value);
                                    }}
                                />

                                {/* Error message */}
                                <div className="text-red-500">
                                    {errors.longitude}
                                </div>
                            </div>
                        </div>
                        <div className="flex justify-end mt-4">
                            <button
                                type="submit"
                                className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-purple-600 rounded-md hover:bg-purple-700 focus:outline-none focus:bg-purple-700"
                                disabled={processing}
                            >
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </Authenticated>
    );
}
