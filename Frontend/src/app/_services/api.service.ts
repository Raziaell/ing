import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { Headers, Http, Response, URLSearchParams } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';

import { IErrorMessage } from "../_models";

@Injectable()
export class ApiService {
  constructor(
    private http: Http,
  ) { }

  private setHeaders(): Headers {
    let headersConfig = {
      'Content-Type': 'application/x-www-form-urlencoded',
    };

    return new Headers(headersConfig);
  }

  private formatErrors(error: any) : Observable<IErrorMessage> {
    debugger;
    var jsonError = error.json();

    var error_description = "";

    if(jsonError.message){
      error_description = jsonError.message;
    }
    
    if(jsonError.modelState){
      for(let key in jsonError.modelState.errors){
        var value = jsonError.modelState.errors[key];        
        error_description += value + " ";
      }
    }
    if(!error_description){
      error_description = jsonError.error_description
    }

    var errorRes = <IErrorMessage>{ "status": error.status, "statusText": error.statusText, "error": error, "error_description": error_description }
    return Observable.throw(errorRes);
  }

  get(path: string, params: URLSearchParams = new URLSearchParams()): Observable<any> {
    var tmp = environment.api_url;
    return this.http.get(`${environment.api_url}${path}`, { headers: this.setHeaders(), search: params })
      .catch(this.formatErrors)
      .map((res: Response) => res.json());
  }

  put(path: string, body: Object = {}): Observable<any> {
    return this.http.put(
      `${environment.api_url}${path}`,
      JSON.stringify(body),
      { headers: this.setHeaders() }
    )
      .catch(this.formatErrors)
      .map((res: Response) => res.json());
  }

  post(path: string, obj: Object = {}): Observable<any> {
    
    var arrayJson = '[' + JSON.stringify(obj) + ']';
  
    return this.http.post(
      `${environment.api_url}${path}`,
      arrayJson,
      { headers: this.setHeaders() }
    )
      .catch(this.formatErrors)
      .map(
      (res: Response) => res.json()
      );
  }

  postNotArray(path: string, obj: Object = {}): Observable<any> {
    
    return this.http.post(
      `${environment.api_url}${path}`,
      obj,
      { headers: this.setHeaders() }
    )
      .catch(this.formatErrors)
      .map(
      (res: Response) => res.json()
      );
  }

  delete(path): Observable<any> {
    return this.http.delete(
      `${environment.api_url}${path}`,
      { headers: this.setHeaders() }
    )
      .catch(this.formatErrors)
      .map((res: Response) => res.json());
  }

  /* The default implementation of OAuthAuthorizationServerHandler only accepts form encoding (i.e. application/x-www-form-urlencoded) and not JSON encoding (application/JSON).
  Your request's ContentType should be application/x-www-form-urlencoded and pass the data in the body as:
  grant_type=password&username=Alice&password=password123
  */
  postForLogin(path: string, body: Object = {}): Observable<any> {
    return this.http.post(`${environment.api_url}${path}`, body)
      .catch(this.formatErrors)
      .map((res: Response) => res.json());
  }
}
