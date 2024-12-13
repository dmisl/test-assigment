const submit_btn = document.getElementById("submit");
const data_table = document.getElementById("data");

// USER SELECT
let user_select = document.querySelector('#user')
let user_name = document.querySelector('#user_name')
let table = document.querySelector('#table')

// Array with month names
let month_names = ['January', 'Februarry', 'March']

submit_btn.onclick = function (e) {
  e.preventDefault()
  data_table.style.display = "block";

  // AFTER SELECTING THE USER WE CHANGE USER NAME
  user_name.innerHTML = user_select.options[user_select.selectedIndex].text

  // REQUESTING TO DATA.PHP FOR BALANCES OF SELECTED USER
  fetch('data.php?user=' + user_select.value)
    .then(response => response.json())
    .then(data => {
      // Uncomment to see json response
      // console.log(data)
      // Filling table with received data
      table.innerHTML = `<tr><th>Mounth</th><th>Amount</th></tr>`
      data.forEach(row => {
        table.innerHTML += `<tr><td>${month_names[row.month-1]}</td><td>${row.balance}</td></tr>`
      });
    })
    .catch(error => {
        console.error(error)
    });

};
