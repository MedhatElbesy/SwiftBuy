import { Component, OnDestroy, OnInit } from '@angular/core';
import { User } from '../models/users';
import { ProfileService } from '../services/profile.service';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Order } from '../models/order';
import Swal from 'sweetalert2';
import { HeaderComponent } from '../components/header/header.component';

@Component({
    selector: 'app-edit-profile',
    standalone: true,
    imports: [CommonModule,ReactiveFormsModule,HeaderComponent],
    templateUrl: './edit-profile.component.html',
    styleUrl: './edit-profile.component.css'
})
export class EditProfileComponent implements OnInit , OnDestroy
{
  users:User[]=[];
  orders: Order[] = [];
  user:User|null = null;
  sub:Subscription | null = null;
  orderSub: Subscription | null = null;
  updateForm: FormGroup;
  baseUrl: string = 'http://localhost:8000/images/';
  constructor(public profileService:ProfileService,public router:Router, public fb:FormBuilder){
    this.updateForm = this.fb.group({
      name: [''],
      email: [''],
      password: [''],
    });

  }

  ngOnInit(): void {
    //const storedUserId = localStorage.getItem('userId');
    const storedUserId = localStorage.getItem('id');
    if (storedUserId) {
      const userId = +storedUserId; // specify the user ID you want to fetch
      this.sub = this.profileService.getById(userId).subscribe(data => {
        this.user = data;
        this.updateForm.patchValue({
          name: data.name,
          email: data.email,
          gender: data.gender
        });
      });

      this.orderSub = this.profileService.getUserOrders(userId).subscribe(data => {
        this.orders = data;
      });
    }else {
      console.error('No userId found in localStorage');
    }
  }
  ngOnDestroy(): void {
    this.sub?.unsubscribe();
    this.orderSub?.unsubscribe();
  }
  onSubmit(): void {
    const storedUserId = localStorage.getItem('id');
    if (storedUserId) {
      const userId = +storedUserId;
      console.log("user id is", userId);
      const updatedData = this.updateForm.value;
      this.profileService.updateUser(userId, updatedData).subscribe(updatedUser => {
        this.user = updatedUser;
        this.router.navigate(['/users']);
      });
    } else {
      console.error('User ID not found in local storage.');
    }
  }

  deleteOrder(orderId: number): void {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.isConfirmed) {
        this.profileService.deleteOrder(orderId).subscribe(
          () => {
            this.orders = this.orders.filter(order => order.id !== orderId);
            Swal.fire(
              'Deleted!',
              'Your order has been deleted.',
              'success'
            );
          },
          error => {
            console.error('Error deleting order', error);
            Swal.fire(
              'Error!',
              'There was an error deleting your order.',
              'error'
            );
          }
        );
      }
    });
  }





}
