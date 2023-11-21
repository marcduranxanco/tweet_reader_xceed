# Xceed Backend Test - Documentation

## Introduction
This document outlines the steps taken to complete the Xceed Backend Test.

The approach to development will follow a progression from an initial simple solution to a more comprehensive and appropriate one through a series of refactorings.  
Each refactoring will be summarized in this documentation along with the corresponding commit or commits.
Commits could contain more extended information about the changes.

### Command list
- `composer test`: test de app
- `composer start`: start the app

### Todo list
- Return tweets uppercase
- Create cache layer
- ✅ Limit the count less than 10 (Value Object instead of int)
- ✅ Test

## Initial Implementation
Sets the foundation for future enhancements. Implemented basic functionality in `TweetConverterController` to return tweets in uppercase.  
The controller retrieves tweets from `TweetRepositoryInMemory`, converts them, and responds with a JSON array

- [Implement basic tweet reader](https://github.com/marcduranxanco/tweet_reader_xceed/commit/ce1e057a6892a8ed98b33ceb0618a9156bcd51ff)

## Add TweetLimit value object and its test
Instead of using `int` type for the `searchByUserName` query, the `TweetLimit` value object is used for better control over that value
Adds tests for the newly introduced TweetLimit value object and the there are some refactor commits

- [Add the TweetLimit VO](https://github.com/marcduranxanco/tweet_reader_xceed/commit/f07d03b0047fe9834e7271daa740e0f37a7800d7): 
- [Test TweetLimit VO validating multiple cases](https://github.com/marcduranxanco/tweet_reader_xceed/commit/cde489a45240c3415f0a27ec60540131719dbaa8): 
- Refactor after testing: [d7c4153](https://github.com/marcduranxanco/tweet_reader_xceed/commit/d7c41536643f1ff74270ef19959f7b797e8d629f) and [cf58130](https://github.com/marcduranxanco/tweet_reader_xceed/commit/cf58130aa5798f851a2a027c0837c97872cde8f1)

## Moving the logic to the app Domain
The `TweetService` is introduced in the domain, extracting business logic from the controller and enhancing reusability.
The decision is made to remove `'../src/Domain/'` from the exclude list to enable autowiring for domain elements.
Added tests for `TweetConverterController` and refactor to move the code to green.

- [TweetService added and refactor service configuration](https://github.com/marcduranxanco/tweet_reader_xceed/commit/09ac9cadaddd06cd2d81cd2531a32826d127a294)
- [Refactor TweetConverterController to use TweetService](https://github.com/marcduranxanco/tweet_reader_xceed/commit/7fdea7682a09790ef90cb2ac381645587cd932d2)
- [Add tests for TweetConverterController](https://github.com/marcduranxanco/tweet_reader_xceed/commit/96c8526ca4fee97f31adc31dec9e9dce79e20069)
- [Refactor code across multiple classes to pass newly added unit tests](https://github.com/marcduranxanco/tweet_reader_xceed/commit/0c8145f685c0a3eb8f82bbc051020f488e84b850)
