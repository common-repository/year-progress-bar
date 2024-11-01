jQuery(function($) {
    // Animate the progress bars
    $(".meter > span").each(function() {
        $(this)
            .data("origWidth", $(this).width())
            .width(0)
            .animate({
                width: $(this).data("origWidth")
            }, 1200);
    });

    // Hide the progress bars initially
    $("#year").hide();
    $("#month").hide();

    // Dropdown change event
$('#purpose').on('change', function() {
    var selectedOption = $(this).val();

    // Hide all progress bars
    $("#year").hide();
    $("#month").hide();

    // Show the selected progress bar based on the option value
    if (selectedOption === '0') {
        $("#year").show();
    } else if (selectedOption === '2') {
        $("#month").show();
    }
});

// Show the Download button
// function showDownload() {
//     $("#btn-Convert-Html2Image").show();
//     alert("Download button clicked!");
// }


    // Hide the Download button initially
    $("#btn-Convert-Html2Image").hide();

    // Show the Download button on Preview button click
    $("#btn-Preview-Image").on('click', function() {
        showDownload();
    });

    // Capture and download the progress bar as an image
    $(document).ready(function($) {
        var element = $("#capture");
        var getCanvas;

        $("#btn-Preview-Image").on('click', function() {
            html2canvas(element, {
                onrendered: function(canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });
        });

        $("#btn-Convert-Html2Image").on('click', function() {
            var imgData = getCanvas.toDataURL("image/png");
            var newData = imgData.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#btn-Convert-Html2Image").attr("download", "ProgressBar.png").attr("href", newData);
        });
    });

   

});
<script>
function showDownload() {
    // Code to handle the button click event
    // Replace with your logic to show download or perform other actions
    // For example:
    var progressType = document.getElementById('year-progress-select').value;
    if (progressType === 'year') {
        // Show Year progress download logic here
        alert("Year progress download logic");
    } else if (progressType === 'month') {
        // Show Month progress download logic here
        alert("Month progress download logic");
    }
}

function toggleProgress() {
    var progressType = document.getElementById('year-progress-select').value;
    var yearProgress = document.getElementById('year-progress');
    var monthProgress = document.getElementById('month-progress');
    
    if (progressType === 'year') {
        yearProgress.style.display = 'block';
        monthProgress.style.display = 'none';
    } else if (progressType === 'month') {
        yearProgress.style.display = 'none';
        monthProgress.style.display = 'block';
    }
}

// Initially toggle the progress based on the selection
toggleProgress();
</script>
