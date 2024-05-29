import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { UserHomeComponent } from "./components/user-home/user-home.component";
import { FooterComponent } from "./components/footer/footer.component";
import { HeaderComponent } from "./components/header/header.component";

@Component({
    selector: 'app-root',
    standalone: true,
    templateUrl: './app.component.html',
    styleUrl: './app.component.css',
    imports: [RouterOutlet, UserHomeComponent,FooterComponent, HeaderComponent]
})
export class AppComponent {
  title = 'Frontend';
}
