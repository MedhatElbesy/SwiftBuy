import { Component } from '@angular/core';
import { ActivatedRoute, Router, RouterLink, RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [RouterLink,RouterOutlet],
  templateUrl: './layout.component.html',
  styleUrl: './layout.component.css'
})
export class LayoutComponent {
  currentRoute: string;
  constructor(private router: Router, private route: ActivatedRoute) {
    this.currentRoute = '';
  }
  isActive(url: string): boolean {
    return this.currentRoute === url;
  }
}
