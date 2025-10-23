function pagination(itemsPerPage, currentPage, totalItems) {
    let totalPages = Math.ceil(totalItems / itemsPerPage);

    if (currentPage < 1) {
        currentPage = 1;
    } else if (currentPage > totalPages) {
        currentPage = totalPages;
    }

    let startIndex = (currentPage - 1) * itemsPerPage;
    let endIndex = startIndex + itemsPerPage - 1;

    return {
        totalPages: totalPages,
        currentPage: currentPage,
        startIndex: startIndex,
        endIndex: endIndex
    };
}