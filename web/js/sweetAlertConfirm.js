function controlDelete(path, date) {
    swal({
        title: "Are you sure?",
        text: "You will delete the booking with date: " + date,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                window.location.replace(path);
            }
        });
    return false;
}

