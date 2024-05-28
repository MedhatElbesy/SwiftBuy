import { Component, OnDestroy, OnInit } from '@angular/core';
import { User } from '../models/users';
import { ProfileService } from '../services/profile.service';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-profile-component',
  standalone: true,
  imports: [CommonModule,ReactiveFormsModule],
  templateUrl: './profile-component.component.html',
  styleUrl: './profile-component.component.css'
})
export class ProfileComponentComponent implements OnInit , OnDestroy
{
  users:User[]=[];
  user:User|null = null;
  sub:Subscription | null = null;
  updateForm: FormGroup;
  constructor(public profileService:ProfileService,public router:Router, public fb:FormBuilder){
    this.updateForm = this.fb.group({
      name: [''],
      email: [''],
      password: [''],
    });

  }

  ngOnInit(): void {
    const userId = 1;  // specify the user ID you want to fetch
    this.sub = this.profileService.getById(userId).subscribe(data => {
      this.user = data;
      this.updateForm.patchValue({
        name: data.name,
        email: data.email,
        gender: data.gender
      });
    });
  }
  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }
  onSubmit(): void {
    if (this.user) {
      const updatedData = this.updateForm.value;
      this.profileService.updateUser(1, updatedData).subscribe(updatedUser => {
        this.user = updatedUser;
      });
    }
  }

}
