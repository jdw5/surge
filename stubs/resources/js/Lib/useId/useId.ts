let idx: number = 0

export default (prefix: string = 'id') => {
    return `${prefix}_${idx++}`
}