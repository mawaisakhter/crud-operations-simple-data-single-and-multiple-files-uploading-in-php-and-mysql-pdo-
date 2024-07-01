function confirmDelete(id) {
    var confirmation = confirm("Are you sure you want to delete this item?");
    if (confirmation) {
        window.location.href = '../Model/Delete.php';
    }
}
