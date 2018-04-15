import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';

import { UserService, SharedDataService } from '../_services/index';
import { ILoginModel } from '../_models';
import { environment } from '../../environments/environment';

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    loginForm: FormGroup;
    loading = false;
    returnUrl: string;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private fb: FormBuilder,
        private userService: UserService,
        private shared: SharedDataService) {
    }

    ngOnInit() {

        this.shared.isAuthenticated = false;

        this.loginForm = this.fb.group({
            'Username': ['', Validators.compose([Validators.required, Validators.pattern("^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$")])],
            'Password': ['', Validators.compose([Validators.required, Validators.minLength(8)])]
        })

    }

    login(model: ILoginModel, isValid: boolean) {
    
        this.loading = true;

        this.userService.loginIot(model).subscribe(
            data => {

                if (data.Trovato == true) {
                    this.shared.isAuthenticated = true;
                    if (data.Ruolo == 'Admin') {
                            this.router.navigate(['./controlpanel']);
                    } else {
                        this.shared.user = model
                        this.router.navigate(['./dashboard']);
                    }
                } else {
                    this.router.navigate(['./error']);
                }
                this.loading = false;
            })}
        
    }
    


