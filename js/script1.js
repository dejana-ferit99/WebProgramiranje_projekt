// Get reference to filter button
const filterButton = document.getElementById('filter-button');

// Add event listener to filter button
filterButton.addEventListener('click', filterTasks);

function filterTasks() {
  // Get the selected date from the input element
  const selectedDate = document.getElementById('date-filter').value;
  // Get the entered name/surname from the input element
  const nameSurname = document.getElementById('name-filter').value;

  // Create an AJAX request
  const xhr = new XMLHttpRequest();

  // Set up the request URL with parameters
  let url = 'filter_tasks.php?';
  if (selectedDate !== '') {
    url += 'date=' + selectedDate;
  }
  if (nameSurname !== '') {
    if (selectedDate !== '') {
      url += '&';
    }
    url += 'name=' + nameSurname;
  }

  // Set up the request
  xhr.open('GET', url, true);

  // Set the callback function for when the request completes
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Parse the response as JSON
      const filteredTasks = JSON.parse(xhr.responseText);

      // Update the table with the filtered results
      updateTable(filteredTasks);
    }
  };

  // Send the request
  xhr.send();
}

function updateTable(tasks) {
  // Get a reference to the table body
  const tableBody = document.querySelector('.task-list__table tbody');

  // Clear existing table rows
  tableBody.innerHTML = '';

  // Populate the table with the filtered data
  tasks.forEach(function (task) {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${task.date}</td>
      <td>${task.start_time}</td>
      <td>${task.end_time}</td>
      <td>${task.workday_description}</td>
      <td>${task.name} ${task.surname}</td>
    `;
    tableBody.appendChild(row);
  });
}
