function timeAgo(unixTime) {
    const now = Date.now() / 1000;
    const diff = now - unixTime;

    if (diff < 300) {
        return "just now";
    } else if (diff < 3600) {
        const minutes = Math.floor(diff / 60);
        return `${minutes} minutes ago`;
    } else if (diff < 28800) {
        const hours = Math.floor(diff / 3600);
        const minutes = Math.round((diff % 3600) / 300) * 5;
        return `${hours} hours${minutes > 0 ? ` ${minutes} minutes` : ''} ago`;
    } else if (diff < 86400) {
        const hours = Math.round(diff / 3600);
        return `${hours} hours ago`;
    } else if (diff < 2592000) {
        const days = Math.floor(diff / 86400);
        return `${days} days ago`;
    } else {
        const date = new Date(unixTime * 1000);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}.${month}.${year}`;
    }
}
