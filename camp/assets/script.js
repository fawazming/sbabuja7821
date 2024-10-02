let circles = document.querySelectorAll('.circle');
let prog = document.querySelector('.progress');
let fields = document.querySelectorAll('fieldset');
let transfer = document.querySelector('#transfer');
// let lcamp = document.querySelector('#lcamp');
let prev = document.querySelector('#prev');
let next = document.querySelector('#next');

transfer.addEventListener('click', () => {
    if (transfer.checked === true) {
        document.querySelector('#btn1').classList.add('d-none');
        document.querySelector('#btn2').classList.toggle('d-none');
    } else {
        document.querySelector('#btn1').classList.remove('d-none');
        document.querySelector('#btn2').classList.toggle('d-none');
    }
})
// lcamp.addEventListener('click', () => {
//     if (lcamp.checked === true) {
//         document.querySelector('#btn1').classList.add('d-none');
//         document.querySelector('#btn3').classList.toggle('d-none');
//         document.querySelector('#gender').required = false;
//         document.querySelector('#phone').required = false;
//         document.querySelector('#email').required = false;
//         // document.querySelector('#category').required = false;
//         document.querySelector('#sch').required = false;
//         document.querySelector('#org').required = false;
//     }else{
//         document.querySelector('#btn1').classList.remove('d-none');
//         document.querySelector('#btn3').classList.toggle('d-none');
//     }
// })
console.log(document.querySelector('#gender').value);

if (document.querySelector('#lb').value) {
    let v = document.querySelector('#lb').value;
    console.log(v)
}

let count = 0;

next.addEventListener('click', () => {
    count++;
    changeFormForward(count, 'n');
});

prev.addEventListener('click', () => {
    count--;
    changeFormForward(count, 'p');
});

function changeFormForward(count, k) {
    switch (count) {
        case 0:
            formry('one', count, k)
            break;
        case 1:
            formry('two', count, k)
            break;
        case 2:
            formry('three', count, k)
            break;
        default:
            break;
    }
}

function formry(el, count, k) {
    let total = 3;

    fields.forEach(field => {
        field.classList.add('d-block');
    });
    if (k == 'n') {
        fields[count].classList.remove('d-none');
        fields[count].classList.add('d-block');
        fields[count - 1].classList.add('d-none');
    }else if(k == 'p'){
        fields[count].classList.remove('d-none');
        fields[count].classList.add('d-block');
        fields[count + 1].classList.add('d-none');
    }


    if (count > 0) {
        prev.disabled = false;
    } else {
        prev.disabled = true;
    }

    if (count == total - 1) {
        next.disabled = true;
    } else {
        next.disabled = false;
    }
}