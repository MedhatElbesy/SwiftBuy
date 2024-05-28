import { Component, OnDestroy, OnInit } from '@angular/core';
import { User } from '../models/users';
import { ProfileService } from '../services/profile.service';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-profile-component',
  standalone: true,
  imports: [],
  templateUrl: './profile-component.component.html',
  styleUrl: './profile-component.component.css'
})
export class ProfileComponentComponent implements OnInit , OnDestroy
{
  users:User[]=[];
  user:User|null = null
  sub:Subscription | null = null
  constructor(public profileService:ProfileService,public router:Router){

  }

  ngOnInit(): void {
    // this.sub = this.profileService.getAll().subscribe(data=>this.users = data);
    const userId = 1;  // specify the user ID you want to fetch
    this.sub = this.profileService.getById(userId).subscribe(data => this.user = data);
  }
  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

}
