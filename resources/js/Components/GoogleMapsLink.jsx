export default function GoogleMapsLink({ latitude, longitude }) {
    return (
        <a
            href={`https://www.google.com/maps?q=${latitude},${longitude}`}
            target="_blank"
            rel="noreferrer"
        >
            Lihat Lokasi
        </a>
    );
}
