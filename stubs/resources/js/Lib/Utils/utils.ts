/**********************************\
|          String methods          |
\**********************************/

export const slugify = (text: string) => {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '') 
}

export const ucFirst = (text: string) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
}

export const ucWords = (text: string) => {
    return text.replace(/\w\S*/g, function (txt) {
        return ucFirst(txt);
    });
}

/**********************************\
|           Date methods           |
\**********************************/

export const recencyFormat = (given: any) => {
    const date = new Date(given);
    const now = new Date();
    const diff = now - date;
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    
    if (hours > 168) {
        return date.toLocaleDateString();
    }
    else if (hours > 48) {
        return `${Math.floor(hours / 24)} days ago`;
    } 
    else if (hours > 24) {
        return 'Yesterday';
    }
    else if (hours > 1) {
        return `${hours} hours ago`;
    } 
    else if (hours > 0) {
        return 'An hour ago'
    }
    else if (minutes > 1) {
        return `${minutes} minutes ago`;
    } 
    else if (minutes > 0) {
        return 'A minute ago'
    }
    else {
        return `Under a minute ago`;
    }
}

export const standardFormat = (given: any) => {
    // Use this to create a standard format for your frontend
    const date = new Date(given);
    return date.toLocaleDateString();
}

