export const byLabel = (item: any) => {
    return item.label;
}

export const byValue = (item: any) => {
    return item.value;
}

export const displayFromProperty = (items: any[], 
        item: any, 
        property: string, 
        field: string,
        defaultText: string = 'No item selected'
    ) => {
    const j = items.find((i: any) => i[property] === item[property]); 
    if (!j) return defaultText
    return j[field];  
}

export const defaultSearchBy = (item: any, query: string, field?: string) => {
    console.log(field)
    if (field == undefined) {
        return item.toLowerCase().includes(query.toLowerCase())
    }

    return item[field].toLowerCase().includes(query.toLowerCase())
}

