import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs/Rx';

import { SharedDataService } from "../_services";

@Injectable()
export class AuthGuard implements CanActivate {
    constructor(
        private shared: SharedDataService,
        private router: Router
    ) { }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (this.shared.isAuthenticated) {            
            return true;
        }
        else {
            this.router.navigate(['./login']);
            return true;
        }
    }
}